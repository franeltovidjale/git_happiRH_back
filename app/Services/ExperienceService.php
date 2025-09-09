<?php

namespace App\Services;

use App\Models\Enterprise;
use App\Models\Experience;
use App\Models\Member;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class ExperienceService
{
    /**
     * Create a new experience.
     *
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function store(array $data, Enterprise $enterprise): Experience
    {
        DB::beginTransaction();

        try {
            // Verify the member belongs to the enterprise
            $member = Member::where('enterprise_id', $enterprise->id)
                ->where('id', $data['member_id'])
                ->firstOrFail();

            $experience = Experience::create([
                'member_id' => $member->id,
                'job_title' => $data['job_title'],
                'sector' => $data['sector'] ?? null,
                'company_name' => $data['company_name'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'] ?? null,
                'responsibilities' => $data['responsibilities'] ?? null,
            ]);

            DB::commit();

            return $experience;
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            throw $e;
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error('Error creating experience: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Update an existing experience.
     *
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function update(array $data, int $experienceId, Enterprise $enterprise): Experience
    {
        DB::beginTransaction();

        try {
            $experience = Experience::whereHas('member', function ($query) use ($enterprise) {
                $query->where('enterprise_id', $enterprise->id);
            })
                ->where('id', $experienceId)
                ->firstOrFail();

            $experience->update([
                'member_id' => $data['member_id'] ?? $experience->member_id,
                'job_title' => $data['job_title'] ?? $experience->job_title,
                'sector' => $data['sector'] ?? $experience->sector,
                'company_name' => $data['company_name'] ?? $experience->company_name,
                'start_date' => $data['start_date'] ?? $experience->start_date,
                'end_date' => $data['end_date'] ?? $experience->end_date,
                'responsibilities' => $data['responsibilities'] ?? $experience->responsibilities,
            ]);

            DB::commit();

            return $experience;
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            throw $e;
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error('Error updating experience: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete an experience.
     *
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function delete(int $experienceId, Enterprise $enterprise): bool
    {
        DB::beginTransaction();

        try {
            $experience = Experience::whereHas('member', function ($query) use ($enterprise) {
                $query->where('enterprise_id', $enterprise->id);
            })
                ->where('id', $experienceId)
                ->firstOrFail();

            $experience->delete();

            DB::commit();

            return true;
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            throw $e;
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error('Error deleting experience: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Find an experience by ID within enterprise scope.
     *
     * @throws ModelNotFoundException
     */
    public function findById(int $experienceId, Enterprise $enterprise): Experience
    {
        return Experience::whereHas('member', function ($query) use ($enterprise) {
            $query->where('enterprise_id', $enterprise->id);
        })
            ->where('id', $experienceId)
            ->firstOrFail();
    }

    /**
     * Get experiences for a specific member.
     */
    public function getByMemberId(int $memberId, Enterprise $enterprise): \Illuminate\Database\Eloquent\Collection
    {
        return Experience::whereHas('member', function ($query) use ($enterprise) {
            $query->where('enterprise_id', $enterprise->id);
        })
            ->where('member_id', $memberId)
            ->orderBy('start_date', 'desc')
            ->get();
    }

    /**
     * Get all experiences for an enterprise.
     */
    public function getAllForEnterprise(Enterprise $enterprise): \Illuminate\Database\Eloquent\Collection
    {
        return Experience::whereHas('member', function ($query) use ($enterprise) {
            $query->where('enterprise_id', $enterprise->id);
        })
            ->orderBy('start_date', 'desc')
            ->get();
    }
}
