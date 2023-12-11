<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'car_companies' => [
        'name' => 'Car Companies',
        'index_title' => 'CarCompanies List',
        'new_title' => 'New Car company',
        'create_title' => 'Create CarCompany',
        'edit_title' => 'Edit CarCompany',
        'show_title' => 'Show CarCompany',
        'inputs' => [
            'logo' => 'Logo',
            'name' => 'Name',
        ],
    ],

    'car_company_car_models' => [
        'name' => 'CarCompany Car Models',
        'index_title' => 'CarModels List',
        'new_title' => 'New Car model',
        'create_title' => 'Create CarModel',
        'edit_title' => 'Edit CarModel',
        'show_title' => 'Show CarModel',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'car_model_car_versions' => [
        'name' => 'CarModel Car Versions',
        'index_title' => 'CarVersions List',
        'new_title' => 'New Car version',
        'create_title' => 'Create CarVersion',
        'edit_title' => 'Edit CarVersion',
        'show_title' => 'Show CarVersion',
        'inputs' => [
            'photo' => 'Photo',
            'name' => 'Name',
            'year' => 'Year',
            'initial_price' => 'Initial Price',
        ],
    ],

    'car_version_car_options' => [
        'name' => 'CarVersion Car Options',
        'index_title' => 'CarOptions List',
        'new_title' => 'New Car option',
        'create_title' => 'Create CarOption',
        'edit_title' => 'Edit CarOption',
        'show_title' => 'Show CarOption',
        'inputs' => [
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
        ],
    ],

    'car_models' => [
        'name' => 'Car Models',
        'index_title' => 'CarModels List',
        'new_title' => 'New Car model',
        'create_title' => 'Create CarModel',
        'edit_title' => 'Edit CarModel',
        'show_title' => 'Show CarModel',
        'inputs' => [
            'name' => 'Name',
            'car_company_id' => 'Car Company',
        ],
    ],

    'car_model_car_versions' => [
        'name' => 'CarModel Car Versions',
        'index_title' => 'CarVersions List',
        'new_title' => 'New Car version',
        'create_title' => 'Create CarVersion',
        'edit_title' => 'Edit CarVersion',
        'show_title' => 'Show CarVersion',
        'inputs' => [
            'year' => 'Year',
            'initial_price' => 'Initial Price',
            'name' => 'Name',
            'photo' => 'Photo',
        ],
    ],

    'car_version_car_options' => [
        'name' => 'CarVersion Car Options',
        'index_title' => 'CarOptions List',
        'new_title' => 'New Car option',
        'create_title' => 'Create CarOption',
        'edit_title' => 'Edit CarOption',
        'show_title' => 'Show CarOption',
        'inputs' => [
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
        ],
    ],

    'car_versions' => [
        'name' => 'Car Versions',
        'index_title' => 'CarVersions List',
        'new_title' => 'New Car version',
        'create_title' => 'Create CarVersion',
        'edit_title' => 'Edit CarVersion',
        'show_title' => 'Show CarVersion',
        'inputs' => [
            'car_model_id' => 'Car Model',
            'name' => 'Name',
            'year' => 'Year',
            'initial_price' => 'Initial Price',
            'photo' => 'Photo',
        ],
    ],

    'car_version_car_options' => [
        'name' => 'CarVersion Car Options',
        'index_title' => 'CarOptions List',
        'new_title' => 'New Car option',
        'create_title' => 'Create CarOption',
        'edit_title' => 'Edit CarOption',
        'show_title' => 'Show CarOption',
        'inputs' => [
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
        ],
    ],

    'car_options' => [
        'name' => 'Car Options',
        'index_title' => 'CarOptions List',
        'new_title' => 'New Car option',
        'create_title' => 'Create CarOption',
        'edit_title' => 'Edit CarOption',
        'show_title' => 'Show CarOption',
        'inputs' => [
            'title' => 'Title',
            'description' => 'Description',
            'price' => 'Price',
            'car_version_id' => 'Car Version',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],
];
