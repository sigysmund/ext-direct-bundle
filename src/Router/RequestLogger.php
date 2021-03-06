<?php
/**
 * TQ\Bundle\ExtDirectBundle\Router\RequestLogger
 *
 * @author    stefan
 * @package   TQ\Bundle\ExtDirectBundle\Router
 * @copyright Copyright (C) 2003-2016 TEQneers GmbH & Co. KG. All rights reserved.
 */

namespace TQ\Bundle\ExtDirectBundle\Router;

use TQ\ExtDirect\Router\RequestCollection;
use TQ\ExtDirect\Router\ResponseCollection;

/**
 * Class RequestLogger
 *
 * @package TQ\Bundle\ExtDirectBundle\Router
 */
class RequestLogger
{
    /**
     * @var float|null
     */
    private $startTime;

    /**
     * @var float|null
     */
    private $endTime;

    /**
     * @var bool
     */
    private $formPost = false;

    /**
     * @var bool
     */
    private $upload = false;

    /**
     * @var string|null
     */
    private $request;

    /**
     * @var string|null
     */
    private $response;

    /**
     *
     */
    public function reset()
    {
        $this->startTime = null;
        $this->endTime   = null;
        $this->formPost  = false;
        $this->upload    = false;
        $this->request   = null;
        $this->response  = null;
    }

    /**
     * @param RequestCollection $request
     */
    public function startRequest(RequestCollection $request)
    {
        $this->startTime = microtime(true) * 1000;
        $this->formPost  = $request->isForm();
        $this->upload    = $request->isUpload();
        $this->request   = json_encode($request);
    }

    /**
     * @param ResponseCollection $response
     */
    public function endRequest(ResponseCollection $response)
    {
        $this->endTime  = microtime(true) * 1000;
        $this->response = json_encode($response);
    }

    /**
     * @return bool
     */
    public function isFormPost()
    {
        return $this->formPost;
    }

    /**
     * @return bool
     */
    public function isUpload()
    {
        return $this->upload;
    }

    /**
     * @param bool $asString
     * @return array|string|null
     */
    public function getRequest($asString = true)
    {
        if ($asString) {
            return $this->request;
        }

        return $this->request ? json_decode($this->request, true) : null;
    }

    /**
     * @param bool $asString
     * @return array|string|null
     */
    public function getResponse($asString = true)
    {
        if ($asString) {
            return $this->response;
        }

        return $this->response ? json_decode($this->response, true) : null;
    }

    /**
     * @return float
     */
    public function getElapsedTime()
    {
        $time = 0.0;
        if ($this->startTime && $this->endTime) {
            $time = $this->endTime - $this->startTime;
        }

        return $time;
    }
}
