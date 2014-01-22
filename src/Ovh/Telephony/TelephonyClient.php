<?php 

namespace Ovh\Telephony;

use Ovh\Common\AbstractClient;
use Ovh\Common\Exception\BadMethodCallException;
use Ovh\Common\Exception\NotImplementedYetByOvhException;
use Ovh\Telephony\Exception\TelephonyException;

class TelephonyClient extends AbstractClient
{
	/**
     * Get Telphony properties
     *
     * @param string $billingAccount
     * @return string Json
     * @throws Exception\TelephonyException
     * @throws BadMethodCallException
     */
    public function getProperties($billingAccount)
    {
        if (!$billingAccount)
            throw new BadMethodCallException('Parameter $billingAccount is missing.');
        try {
            $r = $this->get('telephony/' . $billingAccount)->send();
        } catch (\Exception $e) {
            throw new TelephonyException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }

    /**
     * Set Properties of Telephony account
     *
     * @param string $domain
     * @param array $properties (available keys are callBack & templates)
     * @return \Guzzle\Http\Message\Response
     * @throws \Ovh\Common\Exception\BadMethodCallException
     * @throws Exception\SmsException
     */
    public function setProperties($billingAccount, $properties)
    {
        if (!$billingAccount)
            throw new BadMethodCallException('Parameter $billingAccount is missing.');
        if (!$properties)
            throw new BadMethodCallException('Parameter $properties is missing.');
        if (!is_array($properties))
            throw new BadMethodCallException('Parameter $properties must be a array.');
        $t = array();
        if (array_key_exists('description', $properties))
            $t['description'] = $properties['description'];
        $properties = $t;
        unset($t);
        if (count($properties) == 0)
            throw new BadMethodCallException('Parameter $properties does not contain valid key. valid key is "description"');
        try {
            $r = $this->put('telephony/' . $billingAccount, array('Content-Type' => 'application/json;charset=UTF-8'), json_encode($properties))->send();
        } catch (\Exception $e) {
            throw new TelephonyException($e->getMessage(), $e->getCode(), $e);
        }
        return true;
    }

    /**
     * Services associated with this billing account
     * @param  $billingAccount
     * @return string Json
     */
    public function getBillingAccountServices($billingAccount)
    {
		if (!$billingAccount)
            throw new BadMethodCallException('Parameter $billingAccount is missing.');
        try {
            $r = $this->get('telephony/' . $billingAccount . '/service')->send();
        } catch (\Exception $e) {
            throw new TelephonyException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }

    public function getServiceInfos($billingAccount)
    {
        if (!$billingAccount)
            throw new BadMethodCallException('Parameter $billingAccount is missing.');
        try {
            $r = $this->get('telephony/' . $billingAccount . '/serviceInfos')->send();
        } catch (\Exception $e) {
            throw new TelephonyException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }

    public function getHistoryConsumption($billingAccount)
    {
        if (!$billingAccount)
            throw new BadMethodCallException('Parameter $billingAccount is missing.');
        try {
            $r = $this->get('telephony/' . $billingAccount . '/historyConsumption')->send();
        } catch (\Exception $e) {
            throw new TelephonyException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }

    public function getHistoryConsumptionDate($billingAccount, $date)
    {
        if (!$billingAccount)
            throw new BadMethodCallException('Parameter $billingAccount is missing.');
        if (!$date)
            throw new BadMethodCallException('Parameter $date is missing.');

        if ($date instanceof \Datetime)
        {
            $date = $date->format("Y-m-d");
        }

        try {
            $r = $this->get('telephony/' . $billingAccount . '/historyConsumption/' . $date)->send();
        } catch (\Exception $e) {
            throw new TelephonyException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }

    public function getHistoryConsumptionDocument($billingAccount, $date, $format = "pdf")
    {
        if (!$billingAccount)
            throw new BadMethodCallException('Parameter $billingAccount is missing.');
        if (!$date)
            throw new BadMethodCallException('Parameter $date is missing.');

        if ($date instanceof \Datetime)
        {
            $date = $date->format("Y-m-d");
        }

        if (!in_array($format, array('pdf', 'xml', 'csv')))
            throw new BadMethodCallException('Parameter $format is not valid. Valid value are: "' . join("\", \"", array('pdf', 'xml', 'csv')) . '"');

        try {
            $r = $this->get('telephony/' . $billingAccount . '/historyConsumption/' . $date . '/document?extension=' . $format)->send();
        } catch (\Exception $e) {
            throw new TelephonyException($e->getMessage(), $e->getCode(), $e);
        }
        return $r->getBody(true);
    }
}


 ?>