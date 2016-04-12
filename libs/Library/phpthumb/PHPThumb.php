<?php
/**
 *
 * Licensed under the MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author Ian Selby <ian@gen-x-design.com>
 */
namespace Library\phpthumb;
abstract class PHPThumb
{
    /**
     * The name of the file we're manipulating
     * This must include the path to the file (absolute paths recommended)
     *
     * @var string
     */
    protected $fileName;

    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * What the file format is (mime-type)
     *
     * @var string
     */
    protected $format;

    /**
     * Whether or not the image is hosted remotely
     *
     * @var bool
     */
    protected $remoteImage;

    /**
     * An array of attached plugins to execute in order.
     * @var array
     */
    protected $plugins;

    /**
     * @param $fileName
     * @param array $options
     * @param array $plugins
     */
    public function __construct($fileName, array $options = array(), array $plugins = array())
    {
        $this->fileName    = $fileName;
        $this->remoteImage = false;

        if(!$this->validateRequestedResource($fileName))
        {
        	return null;
        }

        $this->setOptions($options);

        $this->plugins = $plugins;
    }

    abstract public function setOptions(array $options = array());

    /**
     * Check the provided filename/url. If it is a url, validate that it is properly
     * formatted. If it is a file, check to make sure that it actually exists on
     * the filesystem.
     *
     * @param $filename
     * @return bool
     */
    protected function validateRequestedResource($filename)
    {
        if(false !== filter_var($filename, FILTER_VALIDATE_URL)) {
            $this->remoteImage = true;
            return true;
        }

        if(is_file($filename)) {
            return true;
        }

        return false;
    }

    /**
     * Returns the filename.
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Sets the filename.
     * @param $fileName
     * @return PHPThumb
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Returns the format.
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Sets the format.
     * @param $format
     * @return PHPThumb
     */
    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Returns whether the image exists remotely, i.e. it was loaded via a URL.
     * @return bool
     */
    public function getIsRemoteImage()
    {
        return $this->remoteImage;
    }
}
