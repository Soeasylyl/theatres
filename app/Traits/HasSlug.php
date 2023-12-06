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
        if (!empty($this->name)) {
            $this->slug = $this->generateUniqueSlug();
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
            $this->slug = $this->generateUniqueSlug();
        }
    }

    /**
     * Generate a unique slug based on the given name.
     *
     * @return string
     */
    private function generateUniqueSlug(): string
    {
        $slug = Str::slug($this->name);
        $existsSlug = $this->getMorphClass()::where('slug', $slug)
            ->whereNot('id', $this->id)
            ->exists();

        return $existsSlug
            ? sprintf('%s-%s', $slug, uniqid())
            : $slug;
    }
}
