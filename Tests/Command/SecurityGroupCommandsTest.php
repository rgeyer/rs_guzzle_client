<?php

namespace Guzzle\Rs\Tests\Command;

use Guzzle\Rs\Tests\Utils\ClientCommandsBase;
use Guzzle\Rs\Model\SecurityGroup;

class SecurityGroupCommandsTest extends ClientCommandsBase
{
    /**
     * @var SecurityGroup
     */
    protected $_security_group;

    protected function setUp()
    {
        parent::setUp();
        $this->_security_group = new SecurityGroup();
        $this->_security_group->aws_group_name = "Guzzle_Test_$this->_testTs";
        $this->_security_group->aws_description = "Description";
        $this->_security_group->create();
    }

    protected function tearDown()
    {
        $this->_security_group->destroy();
        parent::tearDown();
    }

    /**
     * @group v1_0
     * @group integration
     */
    public function testCanCreateAndDestroyOneSecurityGroup()
    {
        $command = null;
        $sec_grp = $this->executeCommand('ec2_security_groups_create',
            array(
                'ec2_security_group[aws_group_name]' => "Guzzle_Integration_Test_$this->_testTs",
                'ec2_security_group[aws_description]' => "Description"
            ),
            &$command
        );

        $this->assertEquals(201, $command->getResponse()->getStatusCode());
        $this->assertNotNull($command->getResponse()->getHeader('Location'));

        $destroy_result = $this->executeCommand('ec2_security_groups_destroy', array('id' => $sec_grp->id));
        $this->assertEquals(200, $destroy_result->getStatusCode());
    }

    /**
     * @group v1_0
     * @group integration
     */
    public function testCanGetSecurityGroupByIdJson()
    {
        $command = null;
        $result = $this->executeCommand('ec2_security_group', array('id' => $this->_security_group->id), &$command);

        $this->assertEquals(200, $command->getResponse()->getStatusCode());
        $this->assertEquals("Guzzle_Test_$this->_testTs", $result->aws_group_name);
        $this->assertEquals("Description", $result->aws_description);
        $this->assertEquals($this->_security_group->id, $result->id);
        $this->assertEquals($this->_security_group->href, $result->href);
        // For JSON this is available
        $this->assertNotNull($result->aws_owner);
    }

    /**
     * @group v1_0
     * @group integration
     */
    public function testCanGetSecurityGroupByIdXml()
    {
        $command = null;
        $result = $this->executeCommand('ec2_security_group', array('id' => $this->_security_group->id, 'output_format' => '.xml'), &$command);

        $this->assertEquals(200, $command->getResponse()->getStatusCode());
        $this->assertEquals("Guzzle_Test_$this->_testTs", $result->aws_group_name);
        $this->assertEquals("Description", $result->aws_description);
        $this->assertEquals($this->_security_group->id, $result->id);
        $this->assertEquals($this->_security_group->href, $result->href);
        // For JSON this is available
        $this->assertEmpty($result->aws_owner);
    }

    /**
     * @group v1_0
     * @group integration
     */
    public function testCanListAllSecurityGroupsJson()
    {
        $result = $this->executeCommand('ec2_security_groups');

        $this->assertNotNull($result);

        $json_obj = json_decode($result->getBody(true));

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertNotNull($json_obj);
        $this->assertGreaterThan(0, count($json_obj));
    }

    /**
     * @group v1_0
     * @group integration
     */
    public function testCanListAllSecurityGroupsWithCloudIdJson()
    {
        $command = null;
        $result = $this->executeCommand('ec2_security_groups', array('cloud_id' => 1), &$command, 'with_cloud_id');

        $this->assertNotNull($result);

        $json_obj = json_decode($result->getBody(true));

        $this->assertEquals(200, $result->getStatusCode());
        $this->assertNotNull($json_obj);
        $this->assertGreaterThan(0, count($json_obj));
    }

    /**
     * @group v1_0
     * @group integration
     */
    public function testCanListAllSecurityGroupsXml()
    {
        $command = null;
        $result = $this->executeCommand('ec2_security_groups', array('output_format' => '.xml'), &$command);

        $this->assertEquals(200, $command->getResponse()->getStatusCode());
        $this->assertInstanceOf('SimpleXMLElement', $result);
        $this->assertNotNull($result);
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @group v1_0
     * @group integration
     */
    public function testCanListAllSecurityGroupsWithCloudIdXml()
    {
        $command = null;
        $result = $this->executeCommand('ec2_security_groups', array('cloud_id' => 1, 'output_format' => '.xml'), &$command, 'with_cloud_id');

        $this->assertEquals(200, $command->getResponse()->getStatusCode());
        $this->assertInstanceOf('SimpleXMLElement', $result);
        $this->assertNotNull($result);
        $this->assertGreaterThan(0, count($result));
    }

    /**
     * @group v1_0
     * @group integration
     */
    public function testCanAddSecurityGroupPermissionOnAllProtocolsAndPortsForAnotherGroup()
    {
        $this->_security_group->find_by_id($this->_security_group->id);
        $command = null;
        $result = $this->executeCommand('ec2_security_groups_update',
            array(
                'id' => $this->_security_group->id,
                'ec2_security_group[owner]' => $this->_security_group->aws_owner,
                'ec2_security_group[group]' => $this->_security_group->aws_group_name
            ),
            &$command,
            'add_group_all_rules'
        );

        $this->assertEquals(204, $result->getStatusCode());

        $sec_group = new SecurityGroup();
        $sec_group->find_by_id($this->_security_group->id);

        $this->assertEquals(3, count($sec_group->aws_perms));

        foreach($sec_group->aws_perms as $perm)
        {
            $this->assertEquals($this->_security_group->aws_owner, $perm->owner);
            $this->assertEquals($this->_security_group->aws_group_name, $perm->group);
            $this->assertContains($perm->protocol, array('icmp','tcp','udp'));
            if($perm->protocol == 'icmp') {
                $this->assertEquals('-1', $perm->from_port);
                $this->assertEquals('-1', $perm->to_port);
            } else {
                $this->assertEquals('0', $perm->from_port);
                $this->assertEquals('65535', $perm->to_port);
            }
        }
    }

    /**
     * @group v1_0
     * @group integration
     */
    public function testCanAddACidrSecurityGroupPermissions()
    {
        $this->_security_group->find_by_id($this->_security_group->id);
        $command = null;
        $result = $this->executeCommand('ec2_security_groups_update',
            array(
                'id' => $this->_security_group->id,
                'ec2_security_group[cidr_ips]' => '0.0.0.0/0',
                'ec2_security_group[protocol]' => 'tcp',
                'ec2_security_group[from_port]' => 22,
                'ec2_security_group[to_port]' => 22
            ),
            &$command,
            'add_cidr_one_rule'
        );

        $this->assertEquals(204, $result->getStatusCode());

        $sec_group = new SecurityGroup();
        $sec_group->find_by_id($this->_security_group->id);

        $this->assertEquals(1, count($sec_group->aws_perms));
        $this->assertEquals('tcp', $sec_group->aws_perms[0]->protocol);
        $this->assertEquals(22, $sec_group->aws_perms[0]->from_port);
        $this->assertEquals(22, $sec_group->aws_perms[0]->to_port);
    }

    /**
     * @group v1_0
     * @group integration
     */
    public function testCanAddSecurityGroupPermissionOnOneProtocolsAndPortForAnotherGroup()
    {
        $this->_security_group->find_by_id($this->_security_group->id);
        $command = null;
        $result = $this->executeCommand('ec2_security_groups_update',
            array(
                'id' => $this->_security_group->id,
                'ec2_security_group[owner]' => $this->_security_group->aws_owner,
                'ec2_security_group[group]' => $this->_security_group->aws_group_name,
                'ec2_security_group[protocol]' => 'tcp',
                'ec2_security_group[from_port]' => 22,
                'ec2_security_group[to_port]' => 22
            ),
            &$command,
            'add_group_one_rule'
        );

        $this->assertEquals(204, $result->getStatusCode());

        $sec_group = new SecurityGroup();
        $sec_group->find_by_id($this->_security_group->id);

        $this->assertEquals(1, count($sec_group->aws_perms));
        $this->assertEquals($this->_security_group->aws_owner, $sec_group->aws_perms[0]->owner);
        $this->assertEquals($this->_security_group->aws_group_name, $sec_group->aws_perms[0]->group);
        $this->assertEquals('tcp', $sec_group->aws_perms[0]->protocol);
        $this->assertEquals(22, $sec_group->aws_perms[0]->from_port);
        $this->assertEquals(22, $sec_group->aws_perms[0]->to_port);
    }
}