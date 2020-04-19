import {Pipe, PipeTransform} from '@angular/core';
import {Teacher} from "./search-panel.component";

@Pipe({
  name: 'teacherSearch'
})
export class TeacherSearchPipe implements PipeTransform {
  transform(teachers: Teacher[], text: string): Teacher[] {
    let filteredTeachers = [];
    for (let teacher of teachers) {
      let mergedName: string = teacher.name + ' ' + teacher.surname;
      if (mergedName.toLowerCase().includes(text.toLowerCase()))
        filteredTeachers.push(teacher);
    }
    return filteredTeachers;
  }
}
