<?php
namespace Cake\View;

use Cake\Core\Configure;

/**
 * A view class that is used for JSON responses.
 * It allows you to omit templates if you just need to emit JSON string as response.
 *
 */
class JsonView extends SerializedView
{

    /**
     * JSON layouts are located in the json sub directory of `Layouts/`
     *
     * @var string
     */
    public $layoutPath = 'json';

    /**
     * JSON views are located in the 'json' sub directory for controllers' views.
     *
     * @var string
     */
    public $subDir = 'json';

    /**
     * Response type.
     *
     * @var string
     */
    protected $_responseType = 'json';

    /**
     * List of special view vars.
     *
     * @var array
     */
    protected $_specialVars = ['_serialize', '_jsonOptions', '_jsonp'];

    /**
     * Render a JSON view.
     *
     * ### Special parameters
     * `_serialize` To convert a set of view variables into a JSON response.
     *   Its value can be a string for single variable name or array for multiple
     *   names. If true all view variables will be serialized. It unset normal
     *   view template will be rendered.
     * `_jsonp` Enables JSONP support and wraps response in callback function
     *   provided in query string.
     *   - Setting it to true enables the default query string parameter "callback".
     *   - Setting it to a string value, uses the provided query string parameter
     *     for finding the JSONP callback name.
     *
     * @param string|null $view The view being rendered.
     * @param string|null $layout The layout being rendered.
     * @return string|null The rendered view.
     */
    public function render($view = null, $layout = null)
    {
        $return = parent::render($view, $layout);

        if (!empty($this->viewVars['_jsonp'])) {
            $jsonpParam = $this->viewVars['_jsonp'];
            if ($this->viewVars['_jsonp'] === true) {
                $jsonpParam = 'callback';
            }
            if ($this->request->getQuery($jsonpParam)) {
                $return = sprintf('%s(%s)', h($this->request->getQuery($jsonpParam)), $return);
                $this->response->type('js');
            }
        }

        return $return;
    }

    /**
     * Serialize view vars
     *
     * ### Special parameters
     * `_jsonOptions` You can set custom options for json_encode() this way,
     *   e.g. `JSON_HEX_TAG | JSON_HEX_APOS`.
     *
     * @param array|string|bool $serialize The name(s) of the view variable(s)
     *   that need(s) to be serialized. If true all available view variables.
     * @return string|false The serialized data, or boolean false if not serializable.
     */
    protected function _serialize($serialize)
    {
        $data = $this->_dataToSerialize($serialize);

        $jsonOptions = JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT |
            JSON_PARTIAL_OUTPUT_ON_ERROR;

        if (isset($this->viewVars['_jsonOptions'])) {
            if ($this->viewVars['_jsonOptions'] === false) {
                $jsonOptions = 0;
            } else {
                $jsonOptions = $this->viewVars['_jsonOptions'];
            }
        }

        if (Configure::read('debug')) {
            $jsonOptions |= JSON_PRETTY_PRINT;
        }

        $json = self::_formatData($data);

        return json_encode($json, $jsonOptions);
    }

    /**
     * @return array
     */
    protected function _formatData($data) : array
    {
        $is_success = false;
        $status = $this->response->getStatusCode();

        if ($status >= 200 && $status <= 299) {
            $is_success = true;
        }

        $json['success'] = $is_success;

        if (isset($data['JWT']))
        {
            $json['JWT'] = $data['JWT'];

            unset($data['JWT']);
        }

        if (isset($data['error']))
        {
            $json['error'] = $data['error'];

            unset($data['error']);
        }

        $json['data'] = [];

        if ($data)
        {
            $json['data'] = $data;
        }

        if (isset($this->request->paging[$this->name]))
        {
            $json['pagination'] = $this->request->paging[$this->name];
        }

        return $json;
    }

    /**
     * Returns data to be serialized.
     *
     * @param array|string|bool $serialize The name(s) of the view variable(s) that
     *   need(s) to be serialized. If true all available view variables will be used.
     * @return mixed The data to serialize.
     */
    protected function _dataToSerialize($serialize = true)
    {
        if ($serialize === true) {
            $data = array_diff_key(
                $this->viewVars,
                array_flip($this->_specialVars)
            );

            if (empty($data)) {
                return null;
            }

            return $data;
        }

        if (is_array($serialize)) {
            $data = [];
            foreach ($serialize as $alias => $key) {
                if (is_numeric($alias)) {
                    $alias = $key;
                }
                if (array_key_exists($key, $this->viewVars)) {
                    $data[$alias] = $this->viewVars[$key];
                }
            }

            return !empty($data) ? $data : null;
        }

        return isset($this->viewVars[$serialize]) ? $this->viewVars[$serialize] : null;
    }
}
