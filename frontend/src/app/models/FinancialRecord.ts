import { Model } from "./Model";
import { File } from './File';

export class FinancialRecord extends Model{
    files: File[];
    description: string;
}