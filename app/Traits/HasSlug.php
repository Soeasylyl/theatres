<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootHasSlug(): void
    {
        parent::boot();

        static::saving(function ($model) {
            $model->generateSlug();
        });
    }

    /**
     * Generate slug on model creation or update.
     *
     * @return void
     */
    protected function generateSlug(): void
    {
        $name = $this->name ?? '';

        if (empty($this->slug)) {
            $this->slug = $this->generateUniqueSlug($name);
        } elseif ($this->isDirty('name')) {
            $this->slug = $this->generateUniqueSlug($name, $this->getKey());
        }
    }

    /**
     * Generate a unique slug based on the given name.
     *
     * @param string $name
     * @param int|null $id
     * @return string
     */
    protected function generateUniqueSlug(string $name, ?int $id = null): string
    {
        $slug = Str::slug($name);
        $count = static::where('slug', $slug)->whereNot('id', $id)->count();

        return $count > 0 ? "{$slug}-" . ($count + 1) : $slug;
    }
}
