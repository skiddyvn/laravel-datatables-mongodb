<?php

namespace Pimlie\DataTables;

use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Eloquent\Builder;

class MongodbDataTable extends TestQueryDataTable
{
    protected $query;

    /**
     * Can the DataTable engine be created with these parameters.
     *
     * @param mixed $source
     * @return boolean
     */
    public static function canCreate($source): bool
    {
        return $source instanceof Model || $source instanceof Builder ||
            strpos(get_class($source), 'MongoDB\Laravel\Relations') !== false;
    }

    /**
     * MongodbDataTable constructor.
     *
     * @param mixed $model
     */
    public function __construct(protected $model)
    {
        $builder = $model instanceof Model || $model instanceof Builder ? $model : $model->getQuery();
        parent::__construct($builder->getQuery());

        $this->query = $builder;
    }

    /**
     * Not supported: Add columns in collection.
     *
     * @param  array  $names
     * @param  bool|int  $order
     * @return $this
     */
    public function addColumns(array $names, $order = false)
    {
        return $this;
    }

    /**
     * If column name could not be resolved then use primary key.
     *
     * @return string
     */
    protected function getPrimaryKeyName(): string
    {
        return $this->query->getModel()->getKeyName();
    }
}
