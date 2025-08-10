1. Update employees Table Migration
Add the following columns:

employee_id — string, unique.

username — string, unique if needed.

role — string (represents role).

designation — string?.
 
joining_date — date.
 

1. Create departments Table Migration
Fields:

id — primary key.

enterprise_id — foreign key to enterprises table.

name — string, required.

active — boolean, default true.

slug — string, unique per enterprise_id.

Timestamps.

Relationship: A department belongs to an enterprise.

1. Create Pivot Table department_employee
Fields:

department_id — foreign key to departments table.

employee_id — foreign key to employees table.

Timestamps (optional).

Relationship: Many-to-many between employees and departments.

4. Create locations Table Migration
Purpose: Store enterprise office locations.

Fields:

id — primary key.

enterprise_id — foreign key to enterprises table.

name — string, required.

active — boolean, default true.

slug — string, unique per enterprise_id.

Timestamps.

Relationship: A location belongs to an enterprise, and an employee can be linked to one location.

1. Create working_days Table Migration
Purpose: Store detailed working day schedules per employee.

Fields:

id — primary key.

employee_id — unsigned big integer, foreign key to employees table.

weekday — string or enum (monday…sunday).

start_hour — time.

end_hour — time.

active — boolean, default true.

Timestamps.

Relationship: A working day belongs to one employee.

6. Update Models
Employee:

departments() → many-to-many.

location() → belongsTo Location.

workingDays() → hasMany WorkingDay.

Department:

enterprise() → belongsTo Enterprise.

employees() → many-to-many.

Location:

enterprise() → belongsTo Enterprise.

employees() → hasMany Employee.

WorkingDay:

employee() → belongsTo Employee.

7. Create Controllers (API Context Only)
Employer/DepartmentController: CRUD for departments within enterprise.

Employer/LocationController: CRUD for locations within enterprise.

Employer/WorkingDayController: CRUD for working days per employee.

All controllers must:

Use base controller methods for API responses.

Contain no validation (validation handled in FormRequest classes).

Wrap critical DB operations in transactions.

Use try–catch for error handling and log exceptions.

8. Create Form Request Classes 

9. Routes
Add routes to:

routes/employer.php for all employer-controlled endpoints (departments, locations, working days, professional info).

Follow slug-based naming for routes.

10. Validation Rules
Department: name required, active boolean, enterprise_id exists, slug unique per enterprise.

Location: name required, active boolean, enterprise_id exists, slug unique per enterprise.

WorkingDay: employee_id exists, weekday required (enum), start_hour and end_hour required, active boolean.

Employee Professional Info: employee_id unique, username unique if provided, employee_type required, designation optional, working_days JSON optional, joining_date date optional, office_location_id exists.
