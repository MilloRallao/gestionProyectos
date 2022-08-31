<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Incident;
use App\Models\Project;
use Tests\TestCase;

class AllTest extends TestCase
{
    // PROYECTOS //
    public function test_store_project_ok()
    {
        $projectOk = new Project(['name' => 'Proyecto_1']);

        $response = $this->postJson('api/projects', $projectOk->toArray());
        $response->assertStatus(200);
    }

    public function test_store_project_not_ok()
    {
        $projectNotOk = new Project();

        $response = $this->postJson('api/projects', $projectNotOk->toArray());
        $response->assertStatus(422);
    }

    public function test_listing_all_project_participantes_ok()
    {
        $id = 1;
        $response = $this->getJson('api/project-participantes/' . $id);
        $response->assertStatus(200);
    }

    public function test_assign_project_ok_both_permissions()
    {
        $assignProjectOk = ['permissions' => ['project participante', 'project responsable'], 'user_id' => 1, 'project_id' => 1];

        $response = $this->postJson('api/assign-project', $assignProjectOk);
        $response->assertStatus(200);
    }

    public function test_assign_project_ok_one_permission()
    {
        $assignProjectOk = ['permissions' => ['project participante'], 'user_id' => 2, 'project_id' => 1];

        $response = $this->postJson('api/assign-project', $assignProjectOk);
        $response->assertStatus(200);
    }

    public function test_unassign_project_ok()
    {
        $unassignProjectOk = ['user_id' => 1, 'project_id' => 1];

        $response = $this->postJson('api/unassign-project', $unassignProjectOk);
        $response->assertStatus(200);
    }

    // ACTIVIDADES //
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
        $assignActivityOk = ['permissions' => 'activity participante', 'user_id' => 1, 'activity_id' => 1];

        $response = $this->postJson('api/assign-activity', $assignActivityOk);
        $response->assertStatus(200);
    }

    public function test_assign_activity_not_ok()
    {
        $assignActivityNotOk = ['permissions' => 'activity responsable', 'user_id' => 1, 'activity_id' => 1];

        $response = $this->postJson('api/assign-activity', $assignActivityNotOk);
        $response->assertStatus(422);
    }

    public function test_unassign_activity_ok()
    {
        $unassignActivityOk = ['user_id' => 1, 'activity_id' => 1];

        $response = $this->postJson('api/unassign-activity', $unassignActivityOk);
        $response->assertStatus(200);
    }

    // INCIDENCIAS //
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
        $assignIncidentOk = ['user_id' => 1, 'incident_id' => 1];

        $response = $this->postJson('api/assign-incident', $assignIncidentOk);
        $response->assertStatus(200);
    }

    public function test_unassign_incident_ok()
    {
        $unassignIncidentOk = ['user_id' => 1, 'incident_id' => 1];

        $response = $this->postJson('api/unassign-incident', $unassignIncidentOk);
        $response->assertStatus(200);
    }

    public function test_activity_incidents_ok()
    {
        $assignActivity = ['permissions' => 'activity responsable', 'user_id' => 1, 'activity_id' => 1];
        $this->postJson('api/assign-activity', $assignActivity);

        $activityIncidentsOk = ['activity_id' => 1, 'user_id' => 1];
        
        $response = $this->postJson('api/activity-incidents', $activityIncidentsOk);
        $response->assertStatus(200);
    }

    public function test_activity_incidents_not_ok()
    {
        $activityIncidentsNotOk = ['activity_id' => 1, 'user_id' => 2];

        $response = $this->postJson('api/activity-incidents', $activityIncidentsNotOk);
        $response->assertStatus(422);
    }
}
