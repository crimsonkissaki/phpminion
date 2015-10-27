<?php
/**
 * PHPMinion
 *
 * A suite of tools to facilitate development and debugging.
 *
 * @package     PHPMinion
 * @author      Evan Johnson
 * @created     October 9, 2015
 * @version     0.1
 */

namespace PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Classes;

use PHPMinionTest\Utilities\ClassAnalyzer\Mocks\Classes\SlightlyComplexClass;

class ComplexClass
{

    /**
     * @var string
     */
    private $userName;

    /**
     * @var string
     */
    private $userHash;

    /**
     * @var \DateTime
     */
    private $lastLogin;

    /**
     * @var string
     */
    private $userAlias;

    /**
     * @var array
     */
    private $activityLog = [];

    /**
     * @var SimpleClass
     */
    private $configOptions;

    /**
     * @var SlightlyComplexClass[]
     */
    private $slightlyComplexClass;

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;
    }

    /**
     * @return string
     */
    public function getUserHash()
    {
        return $this->userHash;
    }

    /**
     * @param string $userHash
     */
    public function setUserHash($userHash)
    {
        $this->userHash = $userHash;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param \DateTime $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return string
     */
    public function getUserAlias()
    {
        return $this->userAlias;
    }

    /**
     * @param string $userAlias
     */
    public function setUserAlias($userAlias)
    {
        $this->userAlias = $userAlias;
    }

    /**
     * @return array
     */
    public function getActivityLog()
    {
        return $this->activityLog;
    }

    /**
     * @param array $activityLog
     */
    public function setActivityLog($activityLog)
    {
        $this->activityLog = $activityLog;
    }

    /**
     * @return SimpleClass
     */
    public function getConfigOptions()
    {
        return $this->configOptions;
    }

    /**
     * @param SimpleClass $configOptions
     */
    public function setConfigOptions($configOptions)
    {
        $this->configOptions = $configOptions;
    }

    public function __construct()
    {
        $this->configOptions = new SimpleClass();
        for ($i = 0; $i < 3; $i += 1) {
            $this->slightlyComplexClass[] = new SlightlyComplexClass();
        }
    }
}