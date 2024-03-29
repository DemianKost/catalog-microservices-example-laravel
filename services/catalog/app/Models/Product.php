<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\MoneyCast;
use App\Enums\ProductStatus;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

final class Product extends Model
{
    use HasFactory;
    use HasUlids;
    use Searchable;

    protected $fillable = [
        'name',
        'status',
        'description',
        'price',
        'cost',
        'weight',
        'stock',
        'dimensions',
        'category_id',
        'supplier_id',
        'warehouse_id'
    ];

    protected $casts = [
        'status' => ProductStatus::class,
        'dimensions' => AsArrayObject::class,
        'price' => MoneyCast::class,
        'cost' => MoneyCast::class,
    ];

    public function makeAllSearchableUsing() {

    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(
            related: Category::class,
            foreignKey: 'category_id',
        );
    }

    /**
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(
            related: Supplier::class,
            foreignKey: 'supplier_id',
        );
    }

    /**
     * @return BelongsTo
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(
            related: Warehouse::class,
            foreignKey: 'warehouse_id',
        );
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->getKey(),
            'name' => $this->getAttribute('name'),
            'status' => $this->getAttribute('status'),
            'description' => $this->getAttribute('description'),
            'price' => $this->getAttribute('price'),
            'cost' => $this->getAttribute('cost'),
            'weight' => $this->getAttribute('weight'),
            'stock' => $this->getAttribute('stock'),
            'dimensions' => $this->getAttribute('dimensions'),
            'category' => [
                'name' => $this->category->getAttribute('name'),
            ],
            'supplier' => [
                'name' => $this->supplier->getAttribute('name'),
                'reference' => $this->supplier->getAttribute('reference'),
            ],
            'warehouse_id' => [
                'name' => $this->warehouse->getAttribute('name'),
            ],
        ];
    }
}
