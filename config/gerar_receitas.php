<?php

    require __DIR__ . '/../vendor/autoload.php';

    use Dotenv\Dotenv;
    use GuzzleHttp\Client;
    use GuzzleHttp\Exception\RequestException;

    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    $ingredientes = $_POST['lista'];

    $apiKey = $_ENV['API_KEY'] ?? 'default_value';

    $modelo = json_encode([
        'receita' => [
            [
                'nome' => 'Nome da receita',
                'categoria' => 'doce, salgado ou fitness',
                'porcoes' => 'x (subistituir por um numero inteiro)',
                'tempo_de_preparo' => 'x minutos',
                'ingredientes' => [
                    ['nome'=> 'ingrediente_1', 'quant' => 1, 'uni_medida' => 'unidade'],
                    ['nome'=> 'ingrediente_2', 'quant' => 300, 'uni_medida' => 'gramas']
                ],
                'modo_preparo' => [
                    ['etapa' => 'Primeira etapa'],
                    ['etapa' => 'Segunda etapa']
                ],
                'tab_nutri' => [
                    'porcao' => '100 gramas',
                    'informacoes' => [
                        ['item' => 'Valor energético', 'quant' => '140 kcal'],
                        ['item' => 'Carboidrato', 'quant' => '10g'],
                        ['item' => 'Açucares totais', 'quant' => '10g'],
                        ['item' => 'Açucares adicionados', 'quant' => '10g'],
                        ['item' => 'Proteínas', 'quant' => '10g'],
                        ['item' => 'Gordura totais', 'quant' => '10g'],
                        ['item' => 'Gorduras saturadas', 'quant' => '10g'],
                        ['item' => 'Gorduras trans', 'quant' => '10g'],
                        ['item' => 'Fibra alimentar', 'quant' => '10g'],
                        ['item' => 'Sódio', 'quant' => '10g']
                    ]
                ]
            ]
        ]
    ]);

    function gerar_receitas($ingredientes, $apiKey, $modelo){
        $client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ]
        ]);

        $prompt = "Crie uma receita deliciosa utilizando os seguintes ingredientes: " . implode(', ', $ingredientes) . ". Gere a receita em um JSON estruturado seguindo este modelo:\n" . $modelo . "\nResponda apenas com o JSON, sem texto adicional.";

        try{
            $response = $client->post('chat/completions', [
                'json' => [
                    'model' => 'gpt-4',
                    'messages' => [
                        ['role' => 'system', 'content' => 'Você é um assistente de cozinhas que gera receitas simples utilizando apenas os ingredientes disponíveis na cozinha.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 1000,
                    'temperature' => 0.5,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['choices'][0]['message']['content'])) {
                $receitaJson = $data['choices'][0]['message']['content'];

                $receita = json_decode($receitaJson, true);

                if (json_last_error() === JSON_ERROR_NONE) {
                    echo json_encode($receita);
                } else {
                    echo json_encode(array('error'=>'Erro ao gerar receita'));
                }

            } else {
                echo json_encode(array('error'=>'Erro ao gerar receita'));
            }

        }catch (RequestException $e){
            echo json_encode(array('error'=>'Erro ao tentar gerar receita'));
        }
    }

    gerar_receitas($ingredientes, $apiKey, $modelo);