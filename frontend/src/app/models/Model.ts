export class Model{
    id: string;
    sequence: number;
    name: string;
    type: 'EXPENSE' | 'INCOME' | 'BOTH';
    created_at: Date;
    updated_at: Date;
}