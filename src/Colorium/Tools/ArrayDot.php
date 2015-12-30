<?php

namespace Colorium\Tools;

class ArrayDot implements \ArrayAccess, \IteratorAggregate, \Serializable, \Countable
{
    
    /** @var array */
    protected $array = [];


    /**
     * Initialize inner array
     *
     * @param array $input
     */
    public function __construct(array $input = [])
    {
        $this->array = $input;
    }


    /**
     * Bind reference as inner array
     *
     * @param array $input
     * @return static
     */
    public static function bind(array &$input)
    {
        return new static($input);
    }


    /**
     * Whether a offset exists
     *
     * @param mixed $offset
     * @return boolean true on success or false on failure.
     */
    public function offsetExists($offset)
    {
        return static::has($this->array, $offset);
    }


    /**
     * Offset to retrieve
     *
     * @param mixed $offset
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return static::get($this->array, $offset);
    }


    /**
     * Offset to set
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        static::set($this->array, $offset, $value);
    }


    /**
     * Offset to unset
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        static::drop($this->array, $offset);
    }


    /**
     * Retrieve an external iterator
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->array);
    }


    /**
     * String representation of object
     *
     * @return string the string representation of the object or null
     */
    public function serialize()
    {
        return serialize($this->array);
    }


    /**
     * Constructs the object
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $this->array = unserialize($serialized);
    }


    /**
     * Count elements of an object
     *
     * @return int The custom count as an integer.
     */
    public function count()
    {
        return count($this->array);
    }


    /**
     * Check is key exists in array
     *
     * @param array $array
     * @param string $key
     * @return bool
     */
    public static function has(array $array, $key)
    {
        $keys = explode('.', $key);
        foreach($keys as $key) {
            if(!isset($array[$key])) {
                return false;
            }
            $array = $array[$key];
        }

        return true;
    }


    /**
     * Get value from array
     *
     * @param array $array
     * @param string $key
     * @param mixed $fallback
     * @return mixed
     */
    public static function get(array $array, $key, $fallback = null)
    {
        $keys = explode('.', $key);
        foreach($keys as $key) {
            if(!isset($array[$key])) {
                return $fallback;
            }
            $array = $array[$key];
        }

        return $array;
    }


    /**
     * Pop value from sub-array
     *
     * @param array $array
     * @param string $key
     * @return mixed
     */
    public static function pop(array $array, $key)
    {
        $keys = explode('.', $key);
        foreach($keys as $key) {
            if(!isset($array[$key])) {
                return null;
            }
            $array = $array[$key];
        }

        if(!is_array($array)) {
            return null;
        }

        return array_pop($array);
    }


    /**
     * Set value in array
     *
     * @param array $array
     * @param string $key
     * @param $value
     */
    public static function set(array &$array, $key, $value)
    {
        $keys = explode('.', $key);
        foreach($keys as $key) {
            if(!isset($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }

        $array = $value;
    }


    /**
     * Push value in sub-array
     *
     * @param array $array
     * @param string $key
     * @param $value
     */
    public static function push(array &$array, $key, $value)
    {
        $keys = explode('.', $key);
        foreach($keys as $key) {
            if(!isset($array[$key])) {
                $array[$key] = [];
            }
            $array = &$array[$key];
        }

        if(!is_array($array)) {
            $array = [];
        }

        array_push($array, $value);
    }


    /**
     * Delete key in array
     *
     * @param array $array
     * @param string $key
     * @return bool
     */
    public static function drop(array &$array, $key)
    {
        $keys = explode('.', $key);
        $last = array_pop($keys);
        foreach($keys as $key) {
            if(!isset($array[$key])) {
                return false;
            }
            $array = &$array[$key];
        }

        if(isset($array[$last])) {
            unset($array[$last]);
            return true;
        }

        return false;
    }

}