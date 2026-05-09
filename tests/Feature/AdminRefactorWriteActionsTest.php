<?php

namespace Tests\Feature;

use App\Application\Admin\ManageUsers;
use App\Application\Broadcast\DispatchBroadcast;
use App\Application\Referral\ManageAdminReferrals;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdminRefactorWriteActionsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_broadcast_store_validates_channel_and_delegates_dispatch_use_case(): void
    {
        $service = $this->createMock(DispatchBroadcast::class);
        $service->expects($this->once())
            ->method('create')
            ->with(
                [
                    'title' => 'Info',
                    'content' => 'Hello class',
                    'target_role' => 'student',
                ],
                true,
                false,
                false
            )
            ->willReturn((function () {
                $result = new \stdClass();
                $result->recipients_count = 12;
                return $result;
            })());

        $this->app->instance(DispatchBroadcast::class, $service);

        $response = $this->post(route('admin.broadcast-messages.store'), [
            'title' => 'Info',
            'content' => 'Hello class',
            'target_role' => 'student',
            'send_via_email' => '1',
        ]);

        $response->assertRedirect(route('admin.broadcast-messages.index'));
        $response->assertSessionHas('success');
    }

    public function test_broadcast_store_requires_at_least_one_delivery_channel(): void
    {
        $service = $this->createMock(DispatchBroadcast::class);
        $service->expects($this->never())->method('create');
        $this->app->instance(DispatchBroadcast::class, $service);

        $response = $this->post(route('admin.broadcast-messages.store'), [
            'title' => 'Info',
            'content' => 'Hello class',
            'target_role' => 'student',
        ]);

        $response->assertSessionHasErrors('channels');
    }

    public function test_referral_store_reward_delegates_manage_admin_referrals(): void
    {
        $service = $this->createMock(ManageAdminReferrals::class);
        $service->expects($this->once())
            ->method('createReward')
            ->with($this->callback(function (array $data): bool {
                return $data['name'] === 'Voucher'
                    && (int) $data['points_required'] === 100
                    && $data['is_active'] === true;
            }));
        $this->app->instance(ManageAdminReferrals::class, $service);

        $response = $this->post(route('admin.referrals.rewards.store'), [
            'name' => 'Voucher',
            'description' => 'Cash voucher',
            'points_required' => 100,
            'is_active' => '1',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'New reward added to catalog.');
    }

    public function test_user_bulk_assign_teacher_delegates_manage_users(): void
    {
        $this->ensureUsersTableExists();
        DB::table('users')->insert([
            ['id' => 1001],
            ['id' => 1002],
            ['id' => 1003],
        ]);

        $service = $this->createMock(ManageUsers::class);
        $service->expects($this->once())
            ->method('bulkAssignTeacher')
            ->with([1002, 1003], 1001);
        $this->app->instance(ManageUsers::class, $service);

        $response = $this->post(route('admin.users.bulk_assign_teacher'), [
            'user_ids' => json_encode([1002, 1003]),
            'teacher_id' => 1001,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    private function ensureUsersTableExists(): void
    {
        if (Schema::hasTable('users')) {
            return;
        }

        Schema::create('users', function ($table) {
            $table->id();
        });
    }
}
