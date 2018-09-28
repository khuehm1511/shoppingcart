<?php

namespace Khuehm1511\Shoppingcart\Repositories;

use Illuminate\Database\DatabaseManager;
use stdClass;

class DatabaseRepository implements RepositoryInterface
{
    /**
     * Save shopping cart.
     *
     * @param $id
     * @param $instanceName
     * @param $content
     */
    public function createOrUpdate($identifier, $instance, $content)
    {
        if ($this->exists($identifier)) {
            $this->update($identifier, $content);
        } else {
            $this->create($identifier, $instance, $content);
        }
    }

    /**
     * Find shopping cart by its identifier.
     *
     * @param string $identifier=
     *
     * @return stdClass|null
     */
    public function findByIdentifier($identifier)
    {
        return $this->getConnection()->table($this->getTableName())
            ->where('identifier', $identifier)
            ->first();
    }

    /**
     * Remove shopping cart by its identifier.
     *
     * @param string $identifier
     */
    public function remove($identifier)
    {
        $this->getConnection()->table($this->getTableName())
            ->where('identifier', $identifier)
            ->delete();
    }

    /**
     * Create shopping cart instance.
     *
     * @param $id
     * @param $instanceName
     * @param $content
     */
    protected function create($identifier, $instance, $content)
    {
        $this->getConnection()->table($this->getTableName())
            ->insert(['identifier' => $identifier, 'instance' => $instance, 'content' => $content]);
    }

    /**
     * Update shopping cart instance.
     *
     * @param $id
     * @param $instanceName
     * @param $content
     */
    protected function update($identifier, $content)
    {
        $this->getConnection()->table($this->getTableName())
            ->where('identifier', $identifier)
            ->update(['content' => $content]);
    }

    /**
     * Check if shopping cart instance exitsts.
     *
     * @param $id
     * @param $instanceName
     *
     * @return bool
     */
    protected function exists($identifier)
    {
        return $this->getConnection()->table($this->getTableName())->where('identifier', $identifier)->exists();
    }

    /**
     * Get the database connection.
     *
     * @return \Illuminate\Database\Connection
     */
    private function getConnection()
    {
        $connectionName = $this->getConnectionName();

        return app(DatabaseManager::class)->connection($connectionName);
    }

    /**
     * Get the database table name.
     *
     * @return string
     */
    private function getTableName()
    {
        return config('cart.database.table', 'cart');
    }

    /**
     * Get the database connection name.
     *
     * @return string
     */
    private function getConnectionName()
    {
        $connection = config('cart.database.connection');

        return is_null($connection) ? config('database.default') : $connection;
    }
}
