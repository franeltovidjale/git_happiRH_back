Todo — Add Polymorphic Document Model & Migration
1. Create Document Model

    Location: app/Models/Document.php

    Fillable:

        key (document identifier, e.g. letter_of_nomination)

        path (file storage path)

        active (boolean)

        scope (private, public)

    Add morph relationship:

public function documentable()
{
    return $this->morphTo();
}

    Add PHPDoc for each property & relationship.

2. Create Migration create_documents_table

    Location: database/migrations/

    Table: documents

    Columns:

        id → primary key

        documentable_id → morphId

        documentable_type → morphType

        key → string

        path → string, nullable

        active → boolean, default 1

        scope → enum: ['private', 'public']

        timestamps → default

3. Update Employee Model

    Add:

public function documents()
{
    return $this->morphMany(Document::class, 'documentable');
}

    Add PHPDoc for documents.

4. Artisan Commands

php artisan make:model Document -m

