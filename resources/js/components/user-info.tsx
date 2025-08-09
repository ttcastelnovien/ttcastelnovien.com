import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { type User } from '@/types';

export function UserInfo({ user, complete = false }: { user: User; complete?: boolean }) {
	return (
		<>
			<Avatar className="h-8 w-8 overflow-hidden rounded-full">
				<AvatarFallback className="rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
					{user.firstname.at(0)}
					{user.lastname.at(0)}
				</AvatarFallback>
			</Avatar>
			<div className="grid flex-1 text-left text-sm leading-tight">
				<span className="truncate font-medium">{user.firstname}</span>
				{complete && <span className="truncate text-xs text-muted-foreground">{user.username}</span>}
			</div>
		</>
	);
}
