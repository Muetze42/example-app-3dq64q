<?php

namespace App\Nova\Fields;

use Closure;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\BooleanGroup;
use Laravel\Nova\Http\Requests\NovaRequest;
use App\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasPermissions;

class RoleBooleanGroup extends BooleanGroup
{
    /**
     * Create a new field.
     *
     * @param string $name
     * @param string|Closure|callable|object|null $attribute
     * @param (callable(mixed, mixed, ?string):(mixed))|null $resolveCallback
     * @return void
     */
    public function __construct($name, $attribute = null, callable $resolveCallback = null)
    {
        parent::__construct(
            $name,
            $attribute,
            $resolveCallback ?? static function (Collection $permissions) {
                return $permissions->mapWithKeys(function (Role $role) {
                    return [$role->name => true];
                });
            }
        );

        $options = Role::get()->pluck($labelAttribute ?? 'name', 'name')->toArray();

        $this->options($options);
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param NovaRequest $request
     * @param string $requestAttribute
     * @param object $model
     * @param string $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute): void
    {
        if (!$request->exists($requestAttribute)) {
            return;
        }

        $model->roles()->detach();

        collect(json_decode($request[$requestAttribute], true))
            ->filter(static function (bool $value) {
                return $value;
            })
            ->keys()
            ->map(static function ($roleName) use ($model) {
                $role = Role::where('name', $roleName)->first();
                $model->assignRole($role);

                return $roleName;
            });
    }
}
