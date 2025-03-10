import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
    name: 'genericPipe',
    standalone: true
})
export class GenericPipe implements PipeTransform {
  transform(value: string | number | undefined | boolean): string {
    switch (value) {
      case 'EXPENSE':
        return 'SAÍDA';
      case 'INCOME':
        return 'ENTRADA';
      case 'SUPPLIER':
        return 'FORNECEDOR';
      case 'CUSTOMER':
        return 'CLIENTE';
      case 'BOTH':
        return 'AMBOS';
      case 0:
      case '0':
        return 'NÃO';
      case 1:
      case '1':
        return 'SIM';
      case 'BUDGET':
        return 'Orçamento';
      case 'SHOPPING_LIST':
        return 'Lista de compras';
      default:
        return String(value); // Retorna o próprio valor como string se não corresponder aos casos acima
    }
  }
}
