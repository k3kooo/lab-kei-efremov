<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id'];

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function getFullChain(): array
    {
        $chain = [$this->name];
        $currentCategory = $this;
        while ($currentCategory->parent) {
            $currentCategory = $currentCategory->parent;
            array_unshift($chain, $currentCategory->name);
        }
        return $chain;
    }

}
