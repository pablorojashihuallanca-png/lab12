<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Nota extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['user_id', 'titulo', 'contenido'];
    // Accesor: Formatear título con estado
    public function getTituloFormateadoAttribute()
    {
        // Verifica si el recordatorio existe y está cargado antes de usarlo.
        if ($this->recordatorio && $this->recordatorio->completado) {
            return "[Completado] {$this->titulo}";
        }

        return $this->titulo;
    }
    // Relación: Nota pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relación: Nota tiene un recordatorio
    public function recordatorio()
    {
        return $this->hasOne(Recordatorio::class);
    }

    /**
     * Scope para obtener solo las notas activas (no vencidas y no completadas).
     */
    public function scopeActivas($query)
    {
        return $query->whereHas('recordatorio', function ($q) {
            $q->whereDate('fecha_vencimiento', '>=', today())->where('completado', false);
        });
    }

    // Relación: Una nota tiene muchas actividades
    public function actividades()
    {
        return $this->hasMany(Actividad::class);
    }
}
