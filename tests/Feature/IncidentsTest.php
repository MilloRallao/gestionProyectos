<?php

namespace Tests\Feature;

use App\Models\Incident;
use App\Models\User;
use Tests\TestCase;

class IncidentsTest extends TestCase
{
    public function test_store_incident_ok()
    {
        $incidentOk = new Incident(['name' => 'Incidencia_1', 'activity_id' => 1]);

        $response = $this->postJson('api/incidents', $incidentOk->toArray());
        $response->assertStatus(200);
    }

    public function test_store_incident_not_ok_only_name()
    {
        $incidentNotOk = new Incident(['name' => 'Incidencia_1']);

        $response = $this->postJson('api/incidents', $incidentNotOk->toArray());
        $response->assertStatus(422);
    }

    public function test_store_incident_not_ok_only_project_id()
    {
        $incidentNotOk = new Incident(['activity_id' => 1]);

        $response = $this->postJson('api/incidents', $incidentNotOk->toArray());
        $response->assertStatus(422);
    }

    public function test_store_incident_not_ok_empty()
    {
        $incidentNotOk = new Incident();

        $response = $this->postJson('api/incidents', $incidentNotOk->toArray());
        $response->assertStatus(422);
    }

    public function test_assign_incident_ok()
    {
        $assignIncidentOk = new User(['user_id' => 1, 'incident_id' => 1]);

        $response = $this->postJson('api/assign-incident', $assignIncidentOk->toArray());
        $response->assertStatus(200);
    }

    public function test_unassign_incident_ok()
    {
        $unassignIncidentOk = new User(['user_id' => 1, 'incident_id' => 1]);

        $response = $this->postJson('api/unassign-incident', $unassignIncidentOk->toArray());
        $response->assertStatus(200);
    }

    public function test_activity_incidents_ok()
    {
        $activityIncidentsOk = new User(['activity_id' => 1, 'user_id' => 1]);

        $response = $this->postJson('api/activity-incidents', $activityIncidentsOk->toArray());
        $response->assertStatus(200);
    }

    public function test_activity_incidents_not_ok()
    {
        $activityIncidentsNotOk = new User(['activity_id' => 1, 'user_id' => 2]);

        $response = $this->postJson('api/activity-incidents', $activityIncidentsNotOk->toArray());
        $response->assertStatus(200);
    }
}