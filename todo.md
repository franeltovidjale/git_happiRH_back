TODO: Update Without Overwriting Existing Fields
1. users table
Ensure these columns exist, but do not overwrite if they already exist:

photo → string, nullable (path to file)

first_name → string, max 100, required

last_name → string, max 100, required

phone → string, max 20, required, unique if business logic requires

email → string, max 255, required, unique


1. employees table
Keep existing structure — do not duplicate photo, first_name, last_name, phone, or email.

Add only these fields if they don’t exist:

birth_date → date, nullable

marital_status → string or enum, nullable

gender → string or enum, nullable

nationality → string, nullable

address → string or text, nullable

city → string, nullable

state → string, nullable

zip_code → string, nullable

3. Relationships
In Employee model:

Ensure employee belongs to a User (belongsTo(User::class)).

In User model:

Ensure user has one Employee (hasOne(Employee::class)).

4. Controllers & Validation
For forms where an employer edits employee info:

Split validation:

User-related fields → validate & update users table.

Employee-related fields → validate & update employees table.

Ensure file uploads (for photo) update the users table, not employees.
