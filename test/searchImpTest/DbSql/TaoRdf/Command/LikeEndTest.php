<?php

/*
 * This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation; under version 2
 *  of the License (non-upgradable).
 *  
 * This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 * 
 *  You should have received a copy of the GNU General Public License
 *  along with this program; if not, write to the Free Software
 *  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 * 
 *  Copyright (c) 2016 (original work) Open Assessment Technologies SA (under the project TAO-PRODUCT);
 */

namespace oat\search\test\searchImpTest\DbSql\TaoRdf\Command;

use oat\search\DbSql\TaoRdf\Command\LikeEnd;
use oat\search\QueryCriterion;
use oat\search\test\UnitTestHelper;

/**
 * test for LikeEnd
 *
 * @author Christophe GARCIA <christopheg@taotesting.com>
 */
class LikeEndTest extends UnitTestHelper
{
    public function setUp(): void
    {
        $this->instance = new LikeEnd();
        $this->instance->setDriverEscaper(new EscaperStub());
    }

    public function testConvert(): void
    {
        $fixturePredicate = 'http://www.w3.org/2000/01/rdf-schema#label';
        $fixtureValue     = 'test';

        $expected = sprintf('`predicate` = "%s" AND ( `object` LIKE "%%test"', $fixturePredicate);

        $queryCriterion = new QueryCriterion();
        $queryCriterion->setName($fixturePredicate);
        $queryCriterion->setValue($fixtureValue);

        $this->assertSame($expected, $this->instance->convert($queryCriterion));
    }
}
