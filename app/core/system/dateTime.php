<?php

class ClassDateTime
{
    /**
     * The separator for time period singular and plural words
     *
     * @var string
     */
    const PERIOD_SEPARATOR = '/';

    private $_badDateLabel = 'تاريخ غير صحيح';
    private $_noDateLabel = 'لم يتم إدراج التاريخ';
    private $_futureTense = "منذ %s من الآن";
    private $_pastTense = "منذ %s";
    private $_lengths = array(60, 60, 24, 7, 4.35, 12, 10);
    private $_periods = array("ثانية/", "دقيقة/", "ساعة/", "يوم/", "اسبوع/", "شهر/", "سنة/", "عقد/");


    /**
     * Formats a given date / datetime string
     *
     * @param string $date
     * @return string
     */
    public function format($date)
    {
        if(!$date) {
            return $this->_noDateLabel;
        }

        $now       = time();
        $timestamp = strtotime($date);

        // check validity of date
        if(!$timestamp) {
            return $this->_badDateLabel;
        }

        // is it future date or past date
        if($now >= $timestamp) {
            $difference = $now - $timestamp;
            $tense      = $this->_pastTense;

        } else {
            $difference = $timestamp - $now;
            $tense      = $this->_futureTense;
        }

        $limit = count($this->_lengths);
        for($j = 0; $j < $limit && $difference >= $this->_lengths[$j]; $j++) {
            $difference /= $this->_lengths[$j];
        }

        $difference = round($difference);

        $period = $this->_periods[$j];
        if($difference == 1) {
            $period = substr($period, 0, strpos($period, self::PERIOD_SEPARATOR));
        }
        else {
            $period = str_replace(self::PERIOD_SEPARATOR, '', $period);
        }

        return sprintf($tense, "$difference $period");
    }

    /**
     * @return string
     */
    public function getBadDateLabel()
    {
        return $this->_badDateLabel;
    }

    /**
     * @return string
     */
    public function getNoDateLabel()
    {
        return $this->_noDateLabel;
    }

    /**
     * @return string
     */
    public function getFutureTense()
    {
        return $this->_futureTense;
    }

    /**
     * @return string
     */
    public function getPastTense()
    {
        return $this->_pastTense;
    }

    /**
     * @return array
     */
    public function getPeriods()
    {
        return $this->_periods;
    }

    /**
     * @param string $noDateLabel
     * @return Remluben\DateFormat\NiceTime
     */
    public function setBadDateLabel($badDateLabel)
    {
        $this->_badDateLabel = $badDateLabel;
        return $this;
    }

    /**
     * @param string $noDateLabel
     * @return Remluben\DateFormat\NiceTime
     */
    public function setNoDateLabel($noDateLabel)
    {
        $this->_noDateLabel = $noDateLabel;
        return $this;
    }

    /**
     * @param string $futureTense
     * @return Remluben\DateFormat\NiceTime
     */
    public function setFutureTense($futureTense)
    {
        $this->_futureTense = $futureTense;
        return $this;
    }

    /**
     * @param string $pastTense
     * @return Remluben\DateFormat\NiceTime
     */
    public function setPastTense($pastTense)
    {
        $this->_pastTense = $pastTense;
        return $this;
    }


    /**
     * @throws Remluben\DateFormat\InvalidArgumentException
     *         for invalid $periods parameter
     * @param array $periods
     *        specify 8 string for
     *        * second
     *        * minute
     *        * hour
     *        * day
     *        * week
     *        * month
     *        * year
     *        * decade
     * @return Remluben\DateFormat\NiceTime
     */
    public function setPeriods($periods)
    {
        if (!is_array($periods) || count($periods) !== 8) {
            throw new InvalidArgumentException("Invalid parameter \$periods. 8 elements have to be provided.");
        }
        $this->_periods = $periods;
        return $this;
    }
}