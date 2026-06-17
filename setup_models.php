<?php
// Script to populate Laravel models and migrations

$modelsDir = __DIR__ . '/app/Models/';
$migrationsDir = __DIR__ . '/database/migrations/';

function getMigrationFile($dir, $nameContains) {
    $files = scandir($dir);
    foreach ($files as $file) {
        if (strpos($file, $nameContains) !== false) {
            return $dir . $file;
        }
    }
    return null;
}

$migrations = [
    'create_categories_table' => <<<'EOT'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type'); // 'income' or 'expense'
            $table->string('color')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('categories');
    }
};
EOT,

    'create_budgets_table' => <<<'EOT'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('period')->default('monthly');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('budgets');
    }
};
EOT,

    'create_expenses_table' => <<<'EOT'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('expenses');
    }
};
EOT,

    'create_incomes_table' => <<<'EOT'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('incomes');
    }
};
EOT,

    'create_savings_goals_table' => <<<'EOT'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('savings_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('target_amount', 10, 2);
            $table->decimal('current_amount', 10, 2)->default(0);
            $table->date('target_date')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('savings_goals');
    }
};
EOT,

    'create_subscriptions_table' => <<<'EOT'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('stripe_id')->unique();
            $table->string('stripe_status');
            $table->string('stripe_price')->nullable();
            $table->integer('quantity')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('subscriptions');
    }
};
EOT,

    'create_payment_transactions_table' => <<<'EOT'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('stripe_payment_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('currency')->default('usd');
            $table->string('status');
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('payment_transactions');
    }
};
EOT,

    'create_notifications_table' => <<<'EOT'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('notifications');
    }
};
EOT,
];

foreach ($migrations as $name => $content) {
    $file = getMigrationFile($migrationsDir, $name);
    if ($file) {
        file_put_contents($file, $content);
        echo "Updated migration: $file\n";
    } else {
        echo "Migration not found: $name\n";
    }
}

// Now update models
$models = [
    'Category' => <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Category extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'type', 'color'];
    public function user() { return $this->belongsTo(User::class); }
    public function expenses() { return $this->hasMany(Expense::class); }
    public function incomes() { return $this->hasMany(Income::class); }
    public function budgets() { return $this->hasMany(Budget::class); }
}
EOT,

    'Budget' => <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Budget extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'category_id', 'amount', 'period'];
    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
}
EOT,

    'Expense' => <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Expense extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'category_id', 'amount', 'date', 'description'];
    protected $casts = ['date' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
}
EOT,

    'Income' => <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Income extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'category_id', 'amount', 'date', 'description'];
    protected $casts = ['date' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
}
EOT,

    'SavingsGoal' => <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class SavingsGoal extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'target_amount', 'current_amount', 'target_date'];
    protected $casts = ['target_date' => 'date'];
    public function user() { return $this->belongsTo(User::class); }
}
EOT,

    'Subscription' => <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Subscription extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'stripe_id', 'stripe_status', 'stripe_price', 'quantity', 'trial_ends_at', 'ends_at'];
    protected $casts = ['trial_ends_at' => 'datetime', 'ends_at' => 'datetime'];
    public function user() { return $this->belongsTo(User::class); }
}
EOT,

    'PaymentTransaction' => <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class PaymentTransaction extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'stripe_payment_id', 'amount', 'currency', 'status'];
    public function user() { return $this->belongsTo(User::class); }
}
EOT,

    'Notification' => <<<'EOT'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Notification extends Model {
    use HasFactory;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id', 'type', 'notifiable_type', 'notifiable_id', 'data', 'read_at'];
    protected $casts = ['read_at' => 'datetime', 'data' => 'array'];
    public function notifiable() { return $this->morphTo(); }
}
EOT,
];

foreach ($models as $name => $content) {
    $file = $modelsDir . $name . '.php';
    file_put_contents($file, $content);
    echo "Updated model: $file\n";
}

echo "Done.\n";
