<?php
namespace App\Model\Rule;

use Cake\Datasource\EntityInterface;
/*
 * Lorem
 *
 * @method \Cake\ORM\Table find($type = 'all', $options = [])
 */
class AppRule
{
    /**
     * @var object
     */
    private $_options;

    /**
     * @var \Cake\ORM\Table
     */
    private $_repository;

    /**
     * @var \Cake\ORM\Entity
     */
    private $_entity;

    /**
     * @var object
     */
    private $_schema;

    /**
     * @var array
     */
    protected $_column_names = [
        'start' => 'start_at',
        'end' => 'end_at',
        'associated_id' => 'event_place_id'
    ];

    /**
     * @var string
     */
    private $_alias;

    /**
     * @return object
     */
    public function getColumnNames()
    {
        return (object) $this->_column_names;
    }

    /**
     * @return object
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->_alias;
    }

    /**
     * @return \Cake\ORM\Table
     */
    public function getRepository()
    {
        return $this->_repository;
    }

    /**
     * @return \Cake\ORM\Entity
     */
    public function getEntity()
    {
        return $this->_entity;
    }

    /**
     * @return object
     */
    public function getSchema()
    {
        return $this->_schema;
    }

    /**
     * @param EntityInterface $entity
     * @param array $options
     */
    protected function populate (EntityInterface $entity, array $options)
    {
        $this->_options = $options;
        $this->_entity = $entity;
        $this->_repository = $this->_options['repository'];
        $this->_schema = $this->_repository->getSchema();
        $this->_alias = $this->getRepository()->alias();

        foreach ($this->_column_names as $key => $value) {

            if (isset($this->_options['fields'][$key])) {
                $this->_column_names[$key] = $this->_options['fields'][$key];
            }
        }
    }

    /**
     * @return object
     */
    protected function columnChecker ()
    {
        $return = (object) [
            'error' => false,
            'missingColumn' => null
        ];

        foreach ($this->_column_names as $field) {

            if (!$this->getSchema()->column($field)) {
                $return->error = true;
                $return->missingColumn = $field;

                return $return;
            }
        }
        return $return;
    }

    /**
     * @param string $field
     * @throws \Exception If required fields are missing on table
     */
    protected final function throwError (string $field): void
    {
        $message = __('Missing *' . $field . '* field from ' . $this->getSchema()->name() . ' table');
        throw new \Exception($message);
    }

}