<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterFormController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $existingEmails = User::pluck('email')->toArray();
        $email = $this->generateEmail($request->name, $existingEmails);

        $user = User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user, 201);
    }

    function generateEmail(string $name, array $existingEmails)
    {
        $partesNombre = array_map('strtolower', array_filter(explode(' ', trim($name))));

        if (empty($partesNombre)) {
            throw new \InvalidArgumentException('El nombre no puede estar vacío');
        }

        $nombreBase = $partesNombre[0];
        $combinaciones = $this->generarCombinaciones($partesNombre);

        // Probar combinaciones
        foreach ($combinaciones as $usuario) {
            $email = $usuario . '@email.com';
            if (!in_array($email, $existingEmails)) {
                return $email;
            }
        }

        // Fallback con números
        return $this->generarEmailConNumeros($nombreBase, $existingEmails);
    }

    private function generarCombinaciones(array $partesNombre)
    {
        $nombreBase = $partesNombre[0];
        $combinaciones = [$nombreBase];
        $totalPartes = count($partesNombre);

        // Generar combinaciones progresivas
        for ($i = 1; $i < $totalPartes; $i++) {
            // Combinación con apellido actual
            $combinaciones[] = $nombreBase . $partesNombre[$i];

            // Combinación con inicial del apellido actual
            $combinaciones[] = $nombreBase . $partesNombre[$i][0];

            // Combinación acumulativa progresiva
            $combinacionProgresiva = $nombreBase;
            for ($j = 1; $j <= $i; $j++) {
                $combinacionProgresiva .= $partesNombre[$j];
            }
            $combinaciones[] = $combinacionProgresiva;

            // Combinación con iniciales progresivas
            $inicialesProgresivas = $nombreBase;
            for ($j = 1; $j <= $i; $j++) {
                $inicialesProgresivas .= $partesNombre[$j][0];
            }
            $combinaciones[] = $inicialesProgresivas;
        }

        return array_unique($combinaciones); // Eliminar duplicados
    }

    private function generarEmailConNumeros(string $nombreBase, array $existingEmails)
    {
        $numero = 1;
        do {
            $email = $nombreBase . $numero . '@email.com';
            $numero++;
        } while (in_array($email, $existingEmails));

        return $email;
    }
}
