# 🌱 Seeders - Banco de Dados Populado

## 📊 Dados Criados

O banco foi populado com dados realistas para facilitar testes e demonstrações.

### 👤 **Usuários (2)**

| Nome | Email | Senha |
|------|-------|-------|
| Admin | admin@locacar.com | password123 |
| Gerente | gerente@locacar.com | password123 |

---

### 🚗 **Marcas (10)**

1. **Fiat** - 4 modelos
2. **Volkswagen** - 4 modelos
3. **Chevrolet** - 3 modelos
4. **Ford** - 3 modelos
5. **Renault** - 3 modelos
6. **Toyota** - 2 modelos
7. **Honda** - 2 modelos
8. **Hyundai** - 2 modelos
9. **Nissan** - 2 modelos
10. **Jeep** - 2 modelos

**Total: 27 modelos**

---

### 🏎️ **Modelos por Marca**

#### **Fiat**
- Uno (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- Palio (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- Argo (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- Toro (4 portas, 5 lugares, Airbag ✅, ABS ✅)

#### **Volkswagen**
- Gol (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- Polo (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- T-Cross (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- Virtus (4 portas, 5 lugares, Airbag ✅, ABS ✅)

#### **Chevrolet**
- Onix (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- Tracker (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- S10 (4 portas, 5 lugares, Airbag ✅, ABS ✅)

#### **Ford**
- Ka (4 portas, 5 lugares, Airbag ✅, ABS ❌)
- EcoSport (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- Ranger (4 portas, 5 lugares, Airbag ✅, ABS ✅)

#### **Renault**
- Kwid (4 portas, 5 lugares, Airbag ✅, ABS ❌)
- Sandero (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- Duster (4 portas, 5 lugares, Airbag ✅, ABS ✅)

#### **Toyota**
- Corolla (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- Hilux (4 portas, 5 lugares, Airbag ✅, ABS ✅)

#### **Honda**
- Civic (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- HR-V (4 portas, 5 lugares, Airbag ✅, ABS ✅)

#### **Hyundai**
- HB20 (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- Creta (4 portas, 5 lugares, Airbag ✅, ABS ✅)

#### **Nissan**
- Kicks (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- Versa (4 portas, 5 lugares, Airbag ✅, ABS ✅)

#### **Jeep**
- Renegade (4 portas, 5 lugares, Airbag ✅, ABS ✅)
- Compass (4 portas, 5 lugares, Airbag ✅, ABS ✅)

---

### 🚙 **Frota de Carros (30)**

- **Placas:** ABC-1234 até JKL-8260
- **Quilometragem:** Entre 5.000 km e 50.000 km
- **Disponibilidade:** 
  - ✅ Disponíveis: ~20 carros (66%)
  - ❌ Em locação: ~10 carros (34%)

#### Exemplos de Carros:
| Placa | Modelo | Marca | KM | Status |
|-------|--------|-------|-----|--------|
| ABC-1234 | Sandero | Renault | 15.000 | Locado |
| DEF-5678 | Polo | Volkswagen | 25.000 | Disponível |
| GHI-9012 | Toro | Fiat | 10.000 | Disponível |
| JKL-3456 | Gol | Volkswagen | 30.000 | Locado |
| MNO-7890 | Renegade | Jeep | 20.000 | Disponível |

---

### 👥 **Clientes (20)**

Lista de clientes cadastrados:
1. João Silva
2. Maria Santos
3. Pedro Oliveira
4. Ana Costa
5. Carlos Ferreira
6. Juliana Almeida
7. Roberto Souza
8. Fernanda Lima
9. Bruno Rodrigues
10. Camila Martins
11. Lucas Pereira
12. Patrícia Gomes
13. Rafael Barbosa
14. Amanda Ribeiro
15. Thiago Carvalho
16. Beatriz Araújo
17. Guilherme Castro
18. Larissa Rocha
19. Felipe Correia
20. Renata Dias

---

### 📋 **Locações (20)**

#### **Locações Finalizadas (15)**
- Período: Últimos 2 a 6 meses
- Duração: 3 a 14 dias
- Valores: R$ 80,00 a R$ 300,00 por diária
- KM rodados: 100 a 1.000 km por locação
- Status: ✅ Devolvidos

#### **Locações Ativas (5)**
- Período: Últimos 7 dias
- Duração prevista: 5 a 10 dias
- Valores: R$ 80,00 a R$ 300,00 por diária
- Status: 🔄 Em andamento (ainda não devolvidos)
- Campos `data_final_realizado_periodo` e `km_final`: **NULL**

---

## 🔧 **Como Usar**

### **1. Popular o Banco Novamente**
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

### **2. Apenas Executar Seeders (sem recriar tabelas)**
```bash
docker-compose exec app php artisan db:seed
```

### **3. Executar Seeder Específico**
```bash
docker-compose exec app php artisan db:seed --class=MarcaSeeder
```

---

## 🔑 **Credenciais de Teste**

### **API / Frontend**
```
Email: admin@locacar.com
Senha: password123
```

### **Testar Login via cURL**
```bash
curl -X POST http://localhost:8989/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@locacar.com","password":"password123"}'
```

**Resposta:**
```json
{
  "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
}
```

---

## 📊 **Consultas SQL Úteis**

### **Carros por Marca**
```sql
SELECT m.nome as marca, COUNT(c.id) as total_carros
FROM marcas m
LEFT JOIN modelos mo ON m.id = mo.marca_id
LEFT JOIN carros c ON mo.id = c.modelo_id
GROUP BY m.id, m.nome
ORDER BY total_carros DESC;
```

### **Carros Disponíveis**
```sql
SELECT c.placa, m.nome as modelo, ma.nome as marca, c.km, c.disponivel
FROM carros c
JOIN modelos m ON c.modelo_id = m.id
JOIN marcas ma ON m.marca_id = ma.id
WHERE c.disponivel = 1
ORDER BY c.km ASC;
```

### **Locações Ativas**
```sql
SELECT l.id, cl.nome as cliente, c.placa, m.nome as modelo,
       l.data_inicio_periodo, l.data_final_previsto_periodo, l.valor_diaria
FROM locacoes l
JOIN clientes cl ON l.cliente_id = cl.id
JOIN carros c ON l.carro_id = c.id
JOIN modelos m ON c.modelo_id = m.id
WHERE l.data_final_realizado_periodo IS NULL;
```

### **Histórico de Locações por Cliente**
```sql
SELECT cl.nome as cliente, COUNT(l.id) as total_locacoes,
       SUM(DATEDIFF(l.data_final_realizado_periodo, l.data_inicio_periodo) * l.valor_diaria) as valor_total
FROM clientes cl
LEFT JOIN locacoes l ON cl.id = l.cliente_id
WHERE l.data_final_realizado_periodo IS NOT NULL
GROUP BY cl.id, cl.nome
ORDER BY total_locacoes DESC;
```

---

## 🎯 **Cenários de Teste**

### **1. Listar Marcas com Modelos**
```bash
GET /api/v1/marca?atributos_modelos=nome,numero_portas,lugares
```

### **2. Buscar Carros Disponíveis**
```bash
GET /api/v1/carro?filtro=disponivel:=:1
```

### **3. Criar Nova Locação**
```bash
POST /api/v1/locacao
{
  "cliente_id": 1,
  "carro_id": 2,
  "data_inicio_periodo": "2026-01-25 10:00:00",
  "data_final_previsto_periodo": "2026-01-30 10:00:00",
  "valor_diaria": 150.00,
  "km_inicial": 25000
}
```

---

## ✨ **Recursos dos Seeders**

✅ **Dados Realistas:** Marcas e modelos brasileiros populares  
✅ **Frota Variada:** 30 carros com status e KM diferentes  
✅ **Clientes Diversos:** 20 nomes brasileiros comuns  
✅ **Histórico Completo:** 15 locações finalizadas + 5 ativas  
✅ **Valores Reais:** Diárias entre R$ 80 e R$ 300  
✅ **Datas Variadas:** Locações dos últimos 6 meses  
✅ **Emojis no Console:** Feedback visual durante execução  
✅ **Tabela Resumo:** Mostra quantidade de registros criados  

---

## 🐛 **Troubleshooting**

### **Erro: "Unknown database"**
```bash
docker-compose exec app php artisan config:cache
docker-compose restart mysql
```

### **Erro: "Integrity constraint violation"**
Certifique-se que a migration de `locacoes` permite NULL em:
- `data_final_realizado_periodo`
- `km_final`

### **Limpar e Recriar Tudo**
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

---

## 📝 **Personalização**

Para adicionar mais dados, edite:
```
database/seeders/DatabaseSeeder.php
```

Exemplo - adicionar mais clientes:
```php
$clientes = [
    'Seu Nome Aqui',
    'Outro Cliente',
    // ... mais nomes
];
```

---

**🎉 Banco populado e pronto para testes!**
