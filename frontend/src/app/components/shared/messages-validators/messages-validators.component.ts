import { Component, Input } from '@angular/core';
import { AbstractControl, ValidationErrors } from '@angular/forms';

@Component({
  selector: 'app-messages-validators',
  templateUrl: './messages-validators.component.html',
  styleUrls: ['./messages-validators.component.css']
})
export class MessagesValidatorsComponent {
  @Input() control: AbstractControl;
  @Input() field: string = 'O campo';
  @Input() backendErrors: string[] = [];

  get errorMessage(): string | null{
      if(this.control && this.control.errors && this.control.touched){
        return this.getErrorMessage(this.control.errors);
      }
      if (this.backendErrors && this.backendErrors.length > 0) {
        return this.backendErrors.map(error => `${error}`).join('<br>');
      }
      return null;
  }

  private getErrorMessage(errors: ValidationErrors): string | null{
    if(errors['required']){
      return `<i class="fas fa-exclamation-circle"></i> O <strong>${this.field}</strong> é obrigatório.`;
    }
    if(errors['email']){
      return '<i class="fas fa-exclamation-circle"></i> Informe um e-mail válido.';
    }
    if(errors['minlength']){
      return `<i class="fas fa-exclamation-circle"></i> O <strong>${this.field}</strong> deve ter no mínimo ${errors['minlength'].requiredLength} caracteres.`;
    }
    if(errors['maxlength']){
      return `<i class="fas fa-exclamation-circle"></i> O <strong>${this.field}</strong> pode ter no máximo ${errors['maxlength'].requiredLength} caracteres.`;
    }
    return null;
  }
}
