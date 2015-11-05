<?php

namespace wolfram\Tests;
use wolfram\Layer\Connector\SinglePdoConnect;
use wolfram\Models\ActiveRecord;
use wolfram\Models\Vendor;

class VendorClassTest extends \PHPUnit_Framework_TestCase
{

    public function testInsert()
    {
        $STMTstub = $this->getMock('PDOStatement');
        $STMTstub->expects($this->once())
                 ->method('execute');

        $connect = $this->getMock('PDOMock',['prepare','lastInsertId']);

        $connect->expects($this->once())
                ->method('prepare')
                ->will($this->returnValue($STMTstub));

        ActiveRecord::setPDO($connect);

        $vendor = new Vendor();
        $vendor->insert();
    }

    public function testUpdate()
    {
        $STMTstub = $this->getMock('PDOStatement');
        $STMTstub->expects($this->exactly(0))
            ->method('execute');

        $connect = $this->getMock('PDOMock',['prepare','lastInsertId']);

        $connect->expects($this->exactly(0))
            ->method('prepare')
            ->will($this->returnValue($STMTstub));

        ActiveRecord::setPDO($connect);

        $vendor = new Vendor();
        $this->assertEquals($vendor->update(),'Cannot update(): id is not defined');
    }
    /**
     * @dataProvider dataProvider
     * @param $data
     */
    public function testFromArray($data)
    {
        $vendor = new Vendor();
        $vendor = $vendor->fromArray(['id'=>$data['id'], 'name'=>$data['name']]);
        $this->assertEquals(['id'=>$data['id'], 'name'=>$data['name']], ['id'=>$vendor->getId(),'name'=>$vendor->getName()]);
    }


    public function testGetterEmptyObject(){
        $vendor = new Vendor();
        $this->assertNull($vendor->getId());
        $this->assertNull($vendor->getName());
    }

    public function testHasAttributes(){
        $vendor = new Vendor();
        $this->assertObjectHasAttribute('id', $vendor);
        $this->assertObjectHasAttribute('name', $vendor);
    }

    public function dataProvider() {
        return [
            ['id'=>1, 'name' => 'vendor1'],
            ['id'=>2, 'name' => 'vendor2'],
            ['id'=>3, 'name' => 'vendor3'],
        ];
    }


}