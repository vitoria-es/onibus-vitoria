/**
 * Utilitário de tabelas de frequência de ônibus
 * 
 * O código abaixo ajud a extrair os horários das tabelas de frequência
 * do site da Prefeitura Municipal de Vitória (PMV).
 * 
 * URL de exemplo: http://sistemas.vitoria.es.gov.br/redeiti/listarHorario.cfm?cdLinha=0211
 * 
 * Usando o inspetor de código (Chrome ou Firefox), selecione o elemento <tbody>
 * da tabela desejada e cole o código abaixo. O valor retornado será uma lista
 * com os horários.
 */

jQuery($0).find('.txtC').map(function() { return $(this).text(); }).get();
