<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Attendance
 *
 * @property int $id
 * @property string|null $timein
 * @property string|null $timeout
 * @property int $status
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Requests[] $AttendanceRequest
 * @property-read \App\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance whereTimein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance whereTimeout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Attendance whereUserId($value)
 */
	class Attendance extends \Eloquent {}
}

namespace App{
/**
 * App\Requests
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $timein
 * @property string|null $timeout
 * @property string $message
 * @property int $author
 * @property int $status
 * @property int $attendance_id
 * @property-read \App\Attendance $Attendance
 * @property-read \App\User $User
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Requests newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Requests newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Requests query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Requests whereAttendanceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Requests whereAuthor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Requests whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Requests whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Requests whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Requests whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Requests whereTimein($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Requests whereTimeout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Requests whereUpdatedAt($value)
 */
	class Requests extends \Eloquent {}
}

namespace App{
/**
 * App\Role
 *
 * @property int $id
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $User
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserRole[] $UserRole
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int|null $line_manager
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Attendance[] $Attendance
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $Role
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Requests[] $UserRequest
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLineManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\UserRole
 *
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Role $Role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserRole whereUserId($value)
 */
	class UserRole extends \Eloquent {}
}

