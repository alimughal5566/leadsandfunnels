<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmissionOption extends Model
{
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'date_created';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'date_updated';

    protected $perPage = 20;

}
