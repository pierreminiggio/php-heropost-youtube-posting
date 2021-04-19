import post from '@pierreminiggio/heropost-youtube-posting'

const args = process.argv

if (args.length !== 9) {
    console.log('Please use like this : node post.js heropostLogin herpostPassword youtubeChannelId title description youtubeCategoryId videoFilePath')
    process.exit()
}

(async () => {
    try {
        console.log(await post(
            args[2],
            args[3],
            args[4],
            {
                title: args[5],
                description: args[6],
                categoryId: parseInt(args[7]),
                videoFilePath: args[8]
            },
            {show: false}
        ))
    } catch (error) {
        console.log(error.message)
    }
})()
