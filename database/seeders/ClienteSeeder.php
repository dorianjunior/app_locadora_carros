<?php

namespace Database\Seeders;

use App\Models\Cliente;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('👥 Criando clientes...');

        $clientes = [
            ['nome' => 'João Silva', 'email' => 'joao.silva@email.com', 'cpf' => '12345678901', 'telefone' => '(11) 98765-4321', 'endereco' => 'Rua das Flores, 123, São Paulo - SP'],
            ['nome' => 'Maria Santos', 'email' => 'maria.santos@email.com', 'cpf' => '23456789012', 'telefone' => '(11) 98765-4322', 'endereco' => 'Av. Paulista, 1000, São Paulo - SP'],
            ['nome' => 'Pedro Oliveira', 'email' => 'pedro.oliveira@email.com', 'cpf' => '34567890123', 'telefone' => '(21) 98765-4323', 'endereco' => 'Rua do Comércio, 456, Rio de Janeiro - RJ'],
            ['nome' => 'Ana Costa', 'email' => 'ana.costa@email.com', 'cpf' => '45678901234', 'telefone' => '(21) 98765-4324', 'endereco' => 'Av. Atlântica, 789, Rio de Janeiro - RJ'],
            ['nome' => 'Carlos Ferreira', 'email' => 'carlos.ferreira@email.com', 'cpf' => '56789012345', 'telefone' => '(31) 98765-4325', 'endereco' => 'Rua da Liberdade, 321, Belo Horizonte - MG'],
            ['nome' => 'Juliana Almeida', 'email' => 'juliana.almeida@email.com', 'cpf' => '67890123456', 'telefone' => '(31) 98765-4326', 'endereco' => 'Av. Afonso Pena, 654, Belo Horizonte - MG'],
            ['nome' => 'Roberto Souza', 'email' => 'roberto.souza@email.com', 'cpf' => '78901234567', 'telefone' => '(41) 98765-4327', 'endereco' => 'Rua XV de Novembro, 987, Curitiba - PR'],
            ['nome' => 'Fernanda Lima', 'email' => 'fernanda.lima@email.com', 'cpf' => '89012345678', 'telefone' => '(41) 98765-4328', 'endereco' => 'Rua das Araucárias, 147, Curitiba - PR'],
            ['nome' => 'Bruno Rodrigues', 'email' => 'bruno.rodrigues@email.com', 'cpf' => '90123456789', 'telefone' => '(51) 98765-4329', 'endereco' => 'Av. Ipiranga, 258, Porto Alegre - RS'],
            ['nome' => 'Camila Martins', 'email' => 'camila.martins@email.com', 'cpf' => '01234567890', 'telefone' => '(51) 98765-4330', 'endereco' => 'Rua dos Andradas, 369, Porto Alegre - RS'],
            ['nome' => 'Lucas Pereira', 'email' => 'lucas.pereira@email.com', 'cpf' => '11234567890', 'telefone' => '(71) 98765-4331', 'endereco' => 'Av. Sete de Setembro, 741, Salvador - BA'],
            ['nome' => 'Patrícia Gomes', 'email' => 'patricia.gomes@email.com', 'cpf' => '22345678901', 'telefone' => '(71) 98765-4332', 'endereco' => 'Rua do Pelourinho, 852, Salvador - BA'],
            ['nome' => 'Rafael Barbosa', 'email' => 'rafael.barbosa@email.com', 'cpf' => '33456789012', 'telefone' => '(81) 98765-4333', 'endereco' => 'Av. Boa Viagem, 963, Recife - PE'],
            ['nome' => 'Amanda Ribeiro', 'email' => 'amanda.ribeiro@email.com', 'cpf' => '44567890123', 'telefone' => '(81) 98765-4334', 'endereco' => 'Rua do Sol, 159, Recife - PE'],
            ['nome' => 'Thiago Carvalho', 'email' => 'thiago.carvalho@email.com', 'cpf' => '55678901234', 'telefone' => '(85) 98765-4335', 'endereco' => 'Av. Beira Mar, 753, Fortaleza - CE'],
            ['nome' => 'Beatriz Araújo', 'email' => 'beatriz.araujo@email.com', 'cpf' => '66789012345', 'telefone' => '(85) 98765-4336', 'endereco' => 'Rua Dragão do Mar, 357, Fortaleza - CE'],
            ['nome' => 'Guilherme Castro', 'email' => 'guilherme.castro@email.com', 'cpf' => '77890123456', 'telefone' => '(61) 98765-4337', 'endereco' => 'SQN 210, Bloco A, Brasília - DF'],
            ['nome' => 'Larissa Rocha', 'email' => 'larissa.rocha@email.com', 'cpf' => '88901234567', 'telefone' => '(61) 98765-4338', 'endereco' => 'SGAS 915, Lote 72, Brasília - DF'],
            ['nome' => 'Felipe Correia', 'email' => 'felipe.correia@email.com', 'cpf' => '99012345678', 'telefone' => '(19) 98765-4339', 'endereco' => 'Rua Barão de Jaguara, 951, Campinas - SP'],
            ['nome' => 'Renata Dias', 'email' => 'renata.dias@email.com', 'cpf' => '10123456789', 'telefone' => '(19) 98765-4340', 'endereco' => 'Av. Norte Sul, 842, Campinas - SP'],
        ];

        foreach ($clientes as $clienteData) {
            Cliente::firstOrCreate(
                ['cpf' => $clienteData['cpf']],
                $clienteData
            );
        }

        $this->command->info("   ✓ {$this->getCount(Cliente::class)} clientes criados");
    }

    /**
     * Get model count
     */
    private function getCount(string $model): int
    {
        return $model::count();
    }
}
