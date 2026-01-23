<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Carro;
use App\Models\Cliente;
use App\Models\Locacao;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('🌱 Iniciando seeders...');

        // 1. Criar usuários administradores
        $this->command->info('👤 Criando usuários...');
        User::create([
            'name' => 'Admin',
            'email' => 'admin@locacar.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now()
        ]);

        User::create([
            'name' => 'Gerente',
            'email' => 'gerente@locacar.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now()
        ]);

        // 2. Criar marcas
        $this->command->info('🚗 Criando marcas...');
        $marcas = [
            ['nome' => 'Fiat', 'imagem' => 'imagens/fiat.png'],
            ['nome' => 'Volkswagen', 'imagem' => 'imagens/volkswagen.png'],
            ['nome' => 'Chevrolet', 'imagem' => 'imagens/chevrolet.png'],
            ['nome' => 'Ford', 'imagem' => 'imagens/ford.png'],
            ['nome' => 'Renault', 'imagem' => 'imagens/renault.png'],
            ['nome' => 'Toyota', 'imagem' => 'imagens/toyota.png'],
            ['nome' => 'Honda', 'imagem' => 'imagens/honda.png'],
            ['nome' => 'Hyundai', 'imagem' => 'imagens/hyundai.png'],
            ['nome' => 'Nissan', 'imagem' => 'imagens/nissan.png'],
            ['nome' => 'Jeep', 'imagem' => 'imagens/jeep.png'],
        ];

        foreach ($marcas as $marca) {
            Marca::create($marca);
        }

        // 3. Criar modelos por marca
        $this->command->info('🏎️ Criando modelos...');
        $modelos = [
            // Fiat
            ['marca_id' => 1, 'nome' => 'Uno', 'imagem' => 'imagens/uno.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 1, 'nome' => 'Palio', 'imagem' => 'imagens/palio.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 1, 'nome' => 'Argo', 'imagem' => 'imagens/argo.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 1, 'nome' => 'Toro', 'imagem' => 'imagens/toro.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],

            // Volkswagen
            ['marca_id' => 2, 'nome' => 'Gol', 'imagem' => 'imagens/gol.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 2, 'nome' => 'Polo', 'imagem' => 'imagens/polo.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 2, 'nome' => 'T-Cross', 'imagem' => 'imagens/tcross.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 2, 'nome' => 'Virtus', 'imagem' => 'imagens/virtus.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],

            // Chevrolet
            ['marca_id' => 3, 'nome' => 'Onix', 'imagem' => 'imagens/onix.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 3, 'nome' => 'Tracker', 'imagem' => 'imagens/tracker.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 3, 'nome' => 'S10', 'imagem' => 'imagens/s10.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],

            // Ford
            ['marca_id' => 4, 'nome' => 'Ka', 'imagem' => 'imagens/ka.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => false],
            ['marca_id' => 4, 'nome' => 'EcoSport', 'imagem' => 'imagens/ecosport.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 4, 'nome' => 'Ranger', 'imagem' => 'imagens/ranger.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],

            // Renault
            ['marca_id' => 5, 'nome' => 'Kwid', 'imagem' => 'imagens/kwid.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => false],
            ['marca_id' => 5, 'nome' => 'Sandero', 'imagem' => 'imagens/sandero.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 5, 'nome' => 'Duster', 'imagem' => 'imagens/duster.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],

            // Toyota
            ['marca_id' => 6, 'nome' => 'Corolla', 'imagem' => 'imagens/corolla.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 6, 'nome' => 'Hilux', 'imagem' => 'imagens/hilux.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],

            // Honda
            ['marca_id' => 7, 'nome' => 'Civic', 'imagem' => 'imagens/civic.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 7, 'nome' => 'HR-V', 'imagem' => 'imagens/hrv.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],

            // Hyundai
            ['marca_id' => 8, 'nome' => 'HB20', 'imagem' => 'imagens/hb20.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 8, 'nome' => 'Creta', 'imagem' => 'imagens/creta.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],

            // Nissan
            ['marca_id' => 9, 'nome' => 'Kicks', 'imagem' => 'imagens/kicks.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 9, 'nome' => 'Versa', 'imagem' => 'imagens/versa.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],

            // Jeep
            ['marca_id' => 10, 'nome' => 'Renegade', 'imagem' => 'imagens/renegade.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
            ['marca_id' => 10, 'nome' => 'Compass', 'imagem' => 'imagens/compass.png', 'numero_portas' => 4, 'lugares' => 5, 'air_bag' => true, 'abs' => true],
        ];

        foreach ($modelos as $modelo) {
            Modelo::create($modelo);
        }

        // 4. Criar carros (frota)
        $this->command->info('🚙 Criando frota de carros...');
        $placas = [
            'ABC-1234', 'DEF-5678', 'GHI-9012', 'JKL-3456', 'MNO-7890',
            'PQR-1122', 'STU-3344', 'VWX-5566', 'YZA-7788', 'BCD-9900',
            'EFG-1212', 'HIJ-3434', 'KLM-5656', 'NOP-7878', 'QRS-9090',
            'TUV-2121', 'WXY-4343', 'ZAB-6565', 'CDE-8787', 'FGH-0909',
            'IJK-1357', 'LMN-2468', 'OPQ-1593', 'RST-2604', 'UVW-3715',
            'XYZ-4826', 'ABC-5937', 'DEF-6048', 'GHI-7159', 'JKL-8260',
        ];

        $kms = [5000, 10000, 15000, 20000, 25000, 30000, 35000, 40000, 45000, 50000];

        for ($i = 0; $i < 30; $i++) {
            Carro::create([
                'modelo_id' => rand(1, 26),
                'placa' => $placas[$i],
                'disponivel' => $i % 3 !== 0, // 66% disponíveis
                'km' => $kms[array_rand($kms)]
            ]);
        }

        // 5. Criar clientes
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

        foreach ($clientes as $cliente) {
            Cliente::create($cliente);
        }

        // 6. Criar locações (histórico)
        $this->command->info('📋 Criando locações...');
        $valoresDiaria = [80.00, 100.00, 120.00, 150.00, 180.00, 200.00, 250.00, 300.00];

        // Locações finalizadas
        for ($i = 0; $i < 15; $i++) {
            $dataInicio = now()->subDays(rand(60, 180));
            $diasLocacao = rand(3, 14);
            $dataFinalPrevisto = $dataInicio->copy()->addDays($diasLocacao);
            $dataFinalRealizado = $dataFinalPrevisto->copy()->addDays(rand(-1, 2));
            $kmInicial = rand(10000, 50000);
            $kmFinal = $kmInicial + rand(100, 1000);

            Locacao::create([
                'cliente_id' => rand(1, 20),
                'carro_id' => rand(1, 30),
                'data_inicio_periodo' => $dataInicio,
                'data_final_previsto_periodo' => $dataFinalPrevisto,
                'data_final_realizado_periodo' => $dataFinalRealizado,
                'valor_diaria' => $valoresDiaria[array_rand($valoresDiaria)],
                'km_inicial' => $kmInicial,
                'km_final' => $kmFinal,
            ]);
        }

        // Locações ativas (em andamento)
        for ($i = 0; $i < 5; $i++) {
            $dataInicio = now()->subDays(rand(1, 7));
            $diasLocacao = rand(5, 10);
            $dataFinalPrevisto = $dataInicio->copy()->addDays($diasLocacao);
            $kmInicial = rand(10000, 50000);

            Locacao::create([
                'cliente_id' => rand(1, 20),
                'carro_id' => rand(1, 30),
                'data_inicio_periodo' => $dataInicio,
                'data_final_previsto_periodo' => $dataFinalPrevisto,
                'data_final_realizado_periodo' => null, // Ainda não devolvido
                'valor_diaria' => $valoresDiaria[array_rand($valoresDiaria)],
                'km_inicial' => $kmInicial,
                'km_final' => null, // Ainda não devolvido
            ]);
        }

        $this->command->info('✅ Seeders concluídos com sucesso!');
        $this->command->info('');
        $this->command->table(
            ['Recurso', 'Quantidade'],
            [
                ['Usuários', User::count()],
                ['Marcas', Marca::count()],
                ['Modelos', Modelo::count()],
                ['Carros', Carro::count()],
                ['Clientes', Cliente::count()],
                ['Locações', Locacao::count()],
            ]
        );
        $this->command->info('');
        $this->command->info('🔑 Credenciais de acesso:');
        $this->command->info('   Email: admin@locacar.com');
        $this->command->info('   Senha: password123');
    }
}
