Fields from the form
Photo de profil (profile photo) – image upload field

Prénom (first name) – string, required

Nom (last name) – string, required

Numéro de téléphone mobile (mobile phone number) – string, required, max length

Email Address – string, email format, required, unique

Date de naissance (birth date) – date, nullable

État civil (marital status) – enum or string, nullable

Genre (gender) – enum or string, nullable

Nationalité (nationality) – string, nullable

Adresse (address) – text or string, nullable

Ville (city) – string, nullable

État (state) – string, nullable

Code ZIP (zip code) – string, nullable

TODO: Update Employee Model, Migration, and Related Features
Update Employee model

Add/modify attributes:

profile_photo (nullable, string or file path)

first_name (string, required, max 100)

last_name (string, required, max 100)

phone_number (string, required, unique if needed, max 20)

email (string, required, unique, max 255)

birth_date (date, nullable)

marital_status (enum/string, nullable)

gender (enum/string, nullable)

nationality (string, nullable)

address (string/text, nullable)

city (string, nullable)

state (string, nullable)

zip_code (string, nullable)

Update employees migration

Add the new columns with appropriate data types and constraints.

Remove/rename old columns if they are replaced.

Ensure database indexes for fields like email and phone_number if needed.

Update related features

Controllers: Adjust store, update, and validation rules to handle new/modified fields.

Forms & Requests: Update request validation classes.

Views: Ensure the new fields are displayed and editable.

File Handling: Implement profile photo upload & storage logic (using Laravel Storage).

API (if any): Update resource transformers to include new fields.
