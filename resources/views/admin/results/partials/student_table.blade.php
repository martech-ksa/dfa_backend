@if($students->count() > 0)

@foreach($students as $index => $student)

<tr>

<td>
<strong>{{ $index + 1 }}.</strong> 

{{ $student->first_name }}
{{ $student->other_names ?? '' }}
{{ $student->last_name }}

<input type="hidden" name="student_id[]" value="{{ $student->id }}">
</td>

<td>
<input 
type="number" 
name="ca[]" 
class="form-control" 
min="0" 
max="40" 
placeholder="CA (0–40)"
required>
</td>

<td>
<input 
type="number" 
name="exam[]" 
class="form-control" 
min="0" 
max="60" 
placeholder="Exam (0–60)"
required>
</td>

</tr>

@endforeach

@else

<tr>
<td colspan="3" class="text-center text-danger">
No students found for the selected class.
</td>
</tr>

@endif
