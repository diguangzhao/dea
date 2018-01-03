<?php

namespace Dea;

class View {
    
    protected $_path;
    protected $_vars

    public function __construct($path, $vars = null) {
        $this->_path = $path;
    }

    public function __get($key) {
        return $this->_vars[$key];
    }

    public function __set($key, $value) {
        if ($value === null) {
            unset($this->_vars[$key]);
        } else {
            $this->_vars[$key] = $value;
        }
    }

    public function __unset($key)
    {
        unset($this->_vars[$key]);
    }

    public function __isset($key)
    {
        return isset($this->_vars[$key]);
    }

    public function __toString()
    {
        if ($this->_ob_cache !== null) {
            return $this->_ob_cache;
        }

        $path = $this->_path;
        $locale = \Gini\Config::get('system.locale');
        $localeSpecificPath = "@$locale/$path";

        $engines = \Gini\Config::get('view.engines');
        if (isset($GLOBALS['gini.view_map'][$localeSpecificPath])) {
            $realPath = $GLOBALS['gini.view_map'][$localeSpecificPath];
            $engine = $engines[pathinfo($realPath, PATHINFO_EXTENSION)];
        } elseif (isset($GLOBALS['gini.view_map'][$path])) {
            $realPath = $GLOBALS['gini.view_map'][$path];
            $engine = $engines[pathinfo($realPath, PATHINFO_EXTENSION)];
        } else {
            foreach ($engines as $ext => $engine) {
                $realPath = \Gini\Core::locatePharFile(VIEW_DIR, "$localeSpecificPath.$ext");
                if (!$realPath) {
                    $realPath = \Gini\Core::locatePharFile(VIEW_DIR, "$path.$ext");
                }
                if ($realPath) {
                    break;
                }
            }
        }

        if ($engine && $realPath) {
            $class = '\Gini\View\\'.$engine;
            $output = \Gini\IoC::construct($class, $realPath, $this->_vars);
        }

        return $this->_ob_cache = (string) $output;
    }
}