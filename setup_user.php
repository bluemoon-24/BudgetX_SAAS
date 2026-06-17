<?php
$userModelPath = __DIR__ . '/app/Models/User.php';
$content = file_get_contents($userModelPath);

$relationships = <<<'EOT'

    public function categories() { return $this->hasMany(Category::class); }
    public function budgets() { return $this->hasMany(Budget::class); }
    public function expenses() { return $this->hasMany(Expense::class); }
    public function incomes() { return $this->hasMany(Income::class); }
    public function savingsGoals() { return $this->hasMany(SavingsGoal::class); }
    public function subscriptions() { return $this->hasMany(Subscription::class); }
    public function paymentTransactions() { return $this->hasMany(PaymentTransaction::class); }

    public function isAdmin() {
        return $this->role === 'admin';
    }
EOT;

// Insert right before the last closing brace
$pos = strrpos($content, '}');
if ($pos !== false) {
    $content = substr_replace($content, $relationships . "\n}\n", $pos, 1);
    file_put_contents($userModelPath, $content);
    echo "Updated User.php";
} else {
    echo "Could not find closing brace in User.php";
}
