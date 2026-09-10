<?php

namespace App\Notifications;

use App\Models\IeltsWritingPracticeSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StudentWritingSubmittedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public IeltsWritingPracticeSubmission $submission
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $student = $this->submission->user;
        $studentName = $student ? $student->name : 'Student';
        $taskLabel = (int)$this->submission->task_type === 1 ? 'Task 1' : 'Task 2';
        $meetingTitle = $this->submission->meeting ? $this->submission->meeting->title : 'Practice';
        $classPeriodName = $student && $student->classPeriod ? $student->classPeriod->name : null;

        $content = "Student {$studentName}" . ($classPeriodName ? " ({$classPeriodName})" : "") . " telah mengirimkan jawaban untuk IELTS Writing {$taskLabel}: {$meetingTitle}. Silakan periksa dan berikan penilaian.";

        return [
            'title'        => "Submission Writing Baru: {$studentName} ({$taskLabel})",
            'content'      => $content,
            'message'      => $content,
            'source'       => 'Sistem IELTS Writing',
            'action_url'   => route('admin.writing-practice-submissions.show', $this->submission->id),
            'action_label' => 'Lihat Detail & Periksa',
            'submission_id'=> $this->submission->id,
            'student_id'   => $this->submission->user_id,
            'student_name' => $studentName,
            'task_type'    => $this->submission->task_type,
            'meeting_id'   => $this->submission->meeting_id,
        ];
    }
}
