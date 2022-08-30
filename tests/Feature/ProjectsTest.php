<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
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
        $assignProjectOk = new User(['permissions' => ['project participante', 'project responsable'], 'user_id' => 1, 'project_id' => 1]);

        $response = $this->postJson('api/assign-project', $assignProjectOk->toArray());
        $response->assertStatus(200);
    }

    public function test_assign_project_ok_one_permission()
    {
        $assignProjectOk = new User(['permissions' => ['project participante'], 'user_id' => 2, 'project_id' => 1]);

        $response = $this->postJson('api/assign-project', $assignProjectOk->toArray());
        $response->assertStatus(200);
    }

    public function test_unassign_project_ok()
    {
        $unassignProjectOk = new User(['user_id' => 1, 'project_id' => 1]);

        $response = $this->postJson('api/assign-project', $unassignProjectOk->toArray());
        $response->assertStatus(200);
    }
}
