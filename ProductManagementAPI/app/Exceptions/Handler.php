use Illuminate\Http\Request;

public function render($request, Throwable $exception)
{
    if ($request->is('api/*')) {
        return response()->json([
            'message' => $exception->getMessage()
        ], 404);
    }

    return parent::render($request, $exception);
}
