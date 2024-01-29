import { Pipe, PipeTransform } from "@angular/core";

@Pipe({
    name: 'genericpipe'
})
export class GenericPipe implements PipeTransform {
    transform(value: string): string {
        switch (value) {
            case 'EXPENSE':
                return 'SAIDA';
            case 'INCOME':
                return 'ENTRADA';
            case 'CREDITOR':
                return 'FORNECEDOR';
            case 'CLIENT':
                return 'CLIENTE';
            case 'PAID':
                return 'QUITADO';
            case 'PENDING':
                return 'EM ABERTO';
            case 'YES':
                return 'SIM';
            case 'NO':
                return 'NÃO';
            default:
                return 'AMBOS';
        }
    }

}