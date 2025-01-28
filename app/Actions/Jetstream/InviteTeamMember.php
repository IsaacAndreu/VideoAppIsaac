<?php

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Laravel\Jetstream\Mail\TeamInvitation;
use Illuminate\Support\Facades\Validator;
use Laravel\Jetstream\Contracts\InvitesTeamMembers;
use Laravel\Jetstream\Events\InvitingTeamMember;

class InviteTeamMember implements InvitesTeamMembers
{
    /**
     * Invite a new team member to the given team.
     */
    public function invite(User $user, Team $team, string $email, ?string $role = null): void
    {
        Validator::make([
            'email' => $email,
            'role' => $role,
        ], $this->rules())->validate();

        InvitingTeamMember::dispatch($team, $email, $role);

        $team->teamInvitations()->create([
            'email' => $email,
            'role' => $role,
        ]);
    }

    /**
     * Get the validation rules for inviting a team member.
     *
     * @return array<string, array<int, string>>
     */
    protected function rules(): array
    {
        $roles = config('jetstream.roles', []); // Assegurem que sempre sigui un array

        if (!is_array($roles)) {
            $roles = []; // Si per algun motiu no és un array, l'inicialitzem com a array buit
        }

        return [
            'email' => ['required', 'email', 'max:255', 'exists:users,email'],
            'role' => ['nullable', 'string', 'in:' . implode(',', array_keys($roles))],
        ];
    }
}
