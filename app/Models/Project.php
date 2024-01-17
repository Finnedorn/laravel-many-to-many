<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'project_title', 'repo_name','repo_link','slug','preview','description', 'category_id'];

    // ...qua invece creerò una funzione al singolare
    // in quanto user è uno a molti in relazione con projects
    // belongsTo(nomemodeltabelladiuno::class)
    // fatto abbiamo linkato le tabelle in relazione!
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
