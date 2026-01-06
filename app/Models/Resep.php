class Resep extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'bahan', 'langkah', 'gambar', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
