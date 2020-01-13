<?php

namespace App\Entity;

class ServiceSearch
{
    private $serviceName;

    private $serviceLocation;

    /**
     * @return mixed
     */
    public function getServiceName()
    {
        return $this->serviceName;
    }

    /**
     * @param mixed $serviceName
     * @return ServiceSearch
     */
    public function setServiceName($serviceName)
    {
        $this->serviceName = $serviceName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServiceLocation()
    {
        return $this->serviceLocation;
    }

    /**
     * @param mixed $serviceLocation
     * @return ServiceSearch
     */
    public function setServiceLocation($serviceLocation)
    {
        $this->serviceLocation = $serviceLocation;
        return $this;
    }
}
