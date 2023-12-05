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
        }
    }

    /**
     * Generate a unique slug based on the given name.
     *
     * @param string $name
     * @param int|null $id
     * @return string
     */
    private function generateUniqueSlug(string $name, int $id = null): string
    {
        $slug = Str::slug($name);

        return $this->where('slug', $slug)
                    ->whereNot('id', $id)
                    ->exists()
            ? sprintf('%s-%s', $slug, uniqid())
            : $slug;
    }
}
