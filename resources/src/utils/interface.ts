export interface Post {
    id: number;
    message: string;
    upload_filename: string;
    upload_width: number;
    upload_height: number;
    like_num: number;
    liked: boolean;
    name: string;
}
