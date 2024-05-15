<?php

namespace Core\Database\ORM;

use Core\Database\Traits\HasCRUD;
use Core\Database\Traits\HasAttributes;
use Core\Database\Traits\HasMethodCaller;
use Core\Database\Traits\HasQueryBuilder;
use Core\Database\Traits\HasRelation;

/**
 * The base model class for the ORM Core.
 *
 * This abstract class serves as the foundation for all ORM models within the Core.
 * It provides essential functionality for interacting with the database, defining model attributes,
 * handling relationships, and managing CRUD operations.
 *
 * @package Core\Database\ORM
 */
abstract class Model
{
    // Include traits for CRUD operations, attribute handling, method calling, query building, and relationship management
    use HasCRUD, HasAttributes, HasMethodCaller, HasQueryBuilder, HasRelation;

    /**
     * The name of the database table associated with the model.
     *
     * @var string
     */
    protected $table;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for arrays and JSON output.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attribute casts for the model.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ID';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    protected $createdAt = 'created_at';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    protected $updatedAt = 'updated_at';

    /**
     * The name of the "deleted at" column for soft deletes.
     *
     * @var string|null
     */
    protected $deletedAt = null;

    /**
     * Collection of model instances.
     *
     * @var array
     */
    protected $collection = [];
}
