<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\User;
use Tests\TestCase;

class ActivitiesTest extends TestCase
{
    public function test_store_activity_ok()
    {
        $activityOk = new Activity(['name' => 'Actividad_1', 'project_id' => 1]);

        $response = $this->postJson('api/activities', $activityOk->toArray());
        $response->assertStatus(200);
    }

    public function test_store_activity_not_ok_only_name()
    {
        $activityNotOk = new Activity(['name' => 'Actividad_1']);

        $response = $this->postJson('api/activities', $activityNotOk->toArray());
        $response->assertStatus(422);
    }

    public function test_store_activity_not_ok_only_project_id()
    {
        $activityNotOk = new Activity(['project_id' => 1]);

        $response = $this->postJson('api/activities', $activityNotOk->toArray());
        $response->assertStatus(422);
    }

    public function test_store_activity_not_ok_empty()
    {
        $activityNotOk = new Activity();

        $response = $this->postJson('api/activities', $activityNotOk->toArray());
        $response->assertStatus(422);
    }

    public function test_listing_all_activity_participantes_ok()
    {
        $id = 1;
        $response = $this->getJson('api/activity-participantes/' . $id);
        $response->assertStatus(200);
    }

    public function test_assign_activity_ok()
    {
        $assignActivityOk = new User(['permissions' => 'activity participante', 'user_id' => 1, 'activity_id' => 1]);

        $response = $this->postJson('api/assign-activity', $assignActivityOk->toArray());
        $response->assertStatus(200);
    }

    public function test_assign_activity_not_ok()
    {
        $assignActivityNotOk = new User(['permissions' => 'activity responsable', 'user_id' => 1, 'activity_id' => 1]);

        $response = $this->postJson('api/assign-activity', $assignActivityNotOk->toArray());
        $response->assertStatus(422);
    }

    public function test_unassign_activity_ok()
    {
        $unassignActivityOk = new User(['user_id' => 1, 'activity_id' => 1]);

        $response = $this->postJson('api/unassign-activity', $unassignActivityOk->toArray());
        $response->assertStatus(200);
    }
}
