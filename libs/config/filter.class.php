<?php

namespace org\octris\core\config {
    /**
     * Implements FilterIterator for filtering configuration.
     * 
     * @octdoc      c:config/filter
     * @copyright   copyright (c) 2010-2011 by Harald Lapp
     * @author      Harald Lapp <harald@octris.org>
     **
     */
     
    class filter extends \FilterIterator {
        /**
         * Prefix to use as filter.
         *
         * @octdoc  v:filter/$prefix
         * @var     string
         */
        private $prefix = '';
        /**/
        
        /**
         * Constructor.
         *
         * @octdoc  m:filter/__construct
         * @param   Iterator    $iterator   Iterator of collection to filter.
         * @param   string      $prefix     Prefix to filter for.
         */
        public function __construct(Iterator $iterator, $prefix)
        /**/
        {
            parent::__construct($iterator);

            $this->prefix = rtrim($prefix, '.') . '.';
            $this->rewind();
        }

        /**
         * Get copy of filtered array.
         *
         * @octdoc  m:filter/getArrayCopy
         * @param   bool    $clean      Optional, default is FALSE. If TRUE the prefix will be removed from the keys.
         * @return  array               Filtered array.
         */
        public function getArrayCopy($clean = false)
        /**/
        {
            $this->rewind();

            $data = array();
            
            if ($clean) {
                $len = strlen($this->prefix);
                
                foreach ($this as $k => $v) {
                    $data[substr($k, $len)] = $v;
                }
            } else {
                foreach ($this as $k => $v) {
                    $data[$k] = $v;
                }
            }

            $this->rewind();
            
            return $data;
        }

        /**
         * Filter implementation.
         *
         * @octdoc  m:filter/accept
         * @return  bool        Returns TRUE, if element should be part of result.
         */
        public function accept()
        /**/
        {
            return (substr($this->key(), 0, strlen($this->prefix)) == $this->prefix);
        }
    }
}
