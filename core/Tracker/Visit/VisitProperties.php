<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Tracker\Visit;

/**
 * Holds temporary data for tracking requests.
 */
class VisitProperties
{
    /**
     * Information about the current visit. This array holds the column values that will be inserted or updated
     * in the `log_visit` table, or the values for the last known visit of the current visitor.
     *
     * @var array
     */
    private $visitInfo = [];

    /**
     * Holds the original information about the current visit, this data is not changed during request processing
     *
     * @var array
     */
    private $originalVisitInfo = [];

    public function __construct(array $visitInfo = [])
    {
        $this->visitInfo = $visitInfo;
        $this->originalVisitInfo = $visitInfo;
    }

    /**
     * Returns a visit property, or `null` if none is set.
     *
     * @param string $name     The property name.
     * @param bool   $original Default false, return the original value before any request processing changes
     * @return mixed
     */
    public function getProperty(string $name, bool $original = false)
    {
        if ($original) {
            return isset($this->originalVisitInfo[$name]) ? $this->originalVisitInfo[$name] : null;
        } else {
            return isset($this->visitInfo[$name]) ? $this->visitInfo[$name] : null;
        }
    }

    /**
     * Returns all visit properties by reference.
     *
     * @param bool   $original Default false, return the original array values before any request processing changes
     * @return array
     */
    public function &getProperties(bool $original = false): array
    {
        if ($original) {
            return $this->originalVisitInfo;
        } else {
            return $this->visitInfo;
        }
    }

    /**
     * Sets a visit property.
     *
     * @param string $name The property name.
     * @param mixed  $value The property value
     * @param bool   $setOriginal If true then set the original value too
     *
     * @return void
     */
    public function setProperty(string $name, $value, bool $setOriginal = false): void
    {
        $this->visitInfo[$name] = $value;
        if ($setOriginal) {
            $this->originalVisitInfo[$name] = $value;
        }
    }

    /**
     * Unsets all visit properties.
     *
     * @return void
     */
    public function clearProperties(): void
    {
        $this->visitInfo = [];
    }

    /**
     * Sets all visit properties.
     *
     * @param array $properties
     *
     * @return void
     */
    public function setProperties(array $properties): void
    {
        $this->visitInfo = $properties;
    }
}
