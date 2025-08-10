Todo — Add Experience Model, Migration & Update Employee Model
1. Create Experience Model

    Location: app/Models/Experience.php

    Fillable:

        enterprise_id

        employee_id

        job_title (Titre du poste)

        sector (Secteur d’activité de l’entreprise)

        company_name (Nom de l’entreprise)

        start_date (Période de travail — début)

        end_date (Période de travail — fin, nullable)

        responsibilities (Responsabilités, nullable)

    Add PHPDoc for properties & relationships.

    Define employee() relationship → belongsTo Employee.

    Define enterprise() relationship → belongsTo Enterprise.

2. Create Migration create_experiences_table

    Location: database/migrations/

    Table: experiences

    Columns:

        id → primary key

        enterprise_id → foreignId → constrained to enterprises → cascade on delete

        employee_id → foreignId → constrained to employees → cascade on delete

        job_title → string

        sector → string

        company_name → string

        start_date → date

        end_date → date, nullable

        responsibilities → text, nullable

        timestamps → default

3. Update Employee Model

    Location: app/Models/Employee.php

    Add:

public function experiences()
{
    return $this->hasMany(Experience::class);
}

    Add PHPDoc for experiences relationship.

4. Artisan Commands

php artisan make:model Experience -m
