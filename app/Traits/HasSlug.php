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
        static::creating(function ($model) {
            $model->generateSlugOnCreate();
        });

        static::updating(function ($model) {
            $model->generateSlugOnUpdate();
        });
    }

    /**
     * Generate slug on model creation.
     *
     * @return void
     */
    private function generateSlugOnCreate(): void
    {
        if (empty($this->slug) && !empty($this->name)) {
            $this->slug  = $this->generateUniqueSlug($this->name);
        }
    }

    /**
     * Generate slug on model update.
     *
     * @return void
     */
    private function generateSlugOnUpdate(): void
    {
        if ($this->isDirty('name') && !empty($this->name)) {
            $this->slug = $this->generateUniqueSlug($this->name, $this->getKey());
        } else {
            \Log::info('Slug not generated on update', ['name' => $this->name, 'isDirty' => $this->isDirty('name')]);
        }
    }

    /**
     * Generate a unique slug based on the given name.
     *
     * @param string $name
     * @param int|null $id
     * @return string
     */
    private function generateUniqueSlug(string $name, ?int $id = null): string
    {
        $slug = Str::slug($name);
        $exists = $this->where('slug', $slug)->whereNot('id', $id)->exists();

        return $exists ? sprintf('%s-%s', $slug, uniqid()) : $slug;
    }
}
