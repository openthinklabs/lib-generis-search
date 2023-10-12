<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2016-2019 (original work) Open Assessment Technologies SA (under the project TAO-PRODUCT);
 */

namespace oat\search\DbSql\TaoRdf\Command;

use oat\search\base\exception\QueryParsingException;
use oat\search\base\QueryCriterionInterface;

/**
 * create search criterium with for NOT IN operator
 *
 * @author christophe
 */
class NotIn extends AbstractRdfOperator
{
    /**
     * operator
     * @var string
     */
    protected $operator = 'NOT IN';

    /**
     * create condition  for object
     * @param array $values
     * @return string
     */
    protected function setValuesList(array $values)
    {
        $parseValues =  [];
        foreach ($values as $value) {
            $parseValues[] = $this->getDriverEscaper()->quote($this->getDriverEscaper()->escape($value));
        }
        return '(' . implode(' ' . $this->getDriverEscaper()->getFieldsSeparator() . ' ' ,  $parseValues) . ')';
    }

    /**
     * convert Query Param to mysql query string
     * @param QueryCriterionInterface $query
     * @return string
     * @throws QueryParsingException
     */
    public function convert(QueryCriterionInterface $query)
    {
        $value = $query->getValue();
        if (!is_array($value)) {
            $value = [$value];
        }
        return $this->setPropertyName($query->getName()) . ' ' . $this->getOperator() . ' ' . $this->setValuesList($value) . ' ';
    }
}
